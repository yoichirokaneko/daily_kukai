@extends('layouts.admin.app')

@section('content')
<div class="container">
 	<h1>俳句一覧</h1>
 	<p>投句はログインユーザーでなければ行えません。</p>
	<p>ログインは右上のログインボタンより行ってください。</p>
 	<p>初めての方は新規登録ボタンよりユーザー登録を行ってください。</p>
 	<p>１週間で1人5句まで投句、4回まで選句できます。</p>
 	<p></p>
 	@guest
 	@else
	 	<p>今週は残り{{$user->post_time}}回投句できます。残り{{$user->vote_time}}回選句できます。</p>
	 	<p>自分の投句した俳句は黄色で表示されます。自分が選句した俳句は青色で表示されます。</p>
	 	<p>自分の投句にのみ、管理人のコメントが表示されます。</p>
 	@endguest
 	<form method="POST" action="{{ action('AdminPostController@store') }}">
 		@csrf
 		<div class="form-group">
 			<label for="body">投句欄</label>
 			<textarea class="form-control" id="body" name="body" rows="2"></textarea>
 		</div>
 		<button type="submit" class="btn btn-primary">投句</button>
 	</form>

	@foreach($posts as $post)
	<div class="card">
		<?php $voted = 0 ?>
		<div class="card-body
			<?php
				if($uvls != null){
					foreach($uvls as $uvl){
						if($post->id == $uvl->post_id){
							echo ' bg-info';
							$voted = 1;
						}
					}
				}
				if($user != null){
					if($user->id == $post->user_id){
						echo ' bg-warning';
					}
				}
			?>
		">
		<h5>{{$post->post_no}}：{!! nl2br(e($post->body)) !!}</h5>
		<p class="card-text">投稿者：{{$post->user->family_name}}　{{$post->user->haiku_name}}　都道府県：{{$post->user->prefecture}}　得票：{{$post->point}}</p>
		<p class="card-text">投稿日時：{{$post->created_at}}　更新日時：{{$post->updated_at}}</p>
			@if(Auth::user()->id <> $post->user_id)
				<form method="POST" action="{{action('AdminPostController@point')}}">
				    @csrf
				    @method('PUT')
				    <input type="hidden" name="data[0]" value="{{$voted}}">
				    <input type="hidden" name="data[1]" value="{{$post->id}}">
				    <input type="submit" value="選句" class="btn btn-success"></input>
				</form>
			@endif
			@if(Auth::user()->id == $post->user_id)
			<a href="{{ action('AdminPostController@edit', $post->id) }}"  class="btn btn-primary">修正</a>
			@endif
			<a href="{{ action('AdminCommentController@index', $post->id) }}"  class="btn btn-primary">コメント追加</a>
			<form method="POST" action="{{action('AdminPostController@delete')}}">
				    @csrf
				    @method('DELETE')
				    <input type="hidden" name="post_id" value="{{$post->id}}">
				    <input type="submit" value="削除" class="btn btn-danger">
			</form>
		</div>
			@foreach($comments as $comment)
				@if($comment->post_id == $post->id)
				<div class="card-footer">
					<p class="card-text">{!! nl2br(e($comment->body)) !!}</p>
					<p class="card-text">投稿日時：{{$comment->created_at}}　更新日時：{{$comment->updated_at}}</p>
				</div>
				@endif
			@endforeach
	</div>
	@endforeach
</div>
@endsection