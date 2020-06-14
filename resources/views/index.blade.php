@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>俳句一覧</h1>
 	<p>投句はログインユーザーでなければ行えません。</p>
 	<p>１週間で1人5句まで投稿、4回まで投票できます。</p>
 	@guest
 	@else
	 	<p>今週は残り{{$user->post_time}}回投稿できます。残り{{$user->vote_time}}回投票できます。</p>
	 	<p>自分の投句は黄色で表示されます。自分が投票した俳句は青色で表示されます。</p>
	 	<p>自分の投句にのみ、管理人のコメントが表示されます。</p>
 	@endguest
 	<form method="POST" action="{{ action('PostController@store') }}">
 		@csrf
 		<div class="form-group">
 			<label for="body">投句欄</label>
 			<textarea class="form-control" id="body" name="body" rows="2"></textarea>
 		</div>
 		<button type="submit" class="btn btn-primary">作成</button>
 	</form>

	<?php $i = 1 ?>
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
		<h5><?php echo $i ?>：{!! nl2br(e($post->body)) !!}</h5>
		<p class="card-text">投稿日時：{{$post->created_at}}　更新日時：{{$post->updated_at}}</p>
		@guest
		@else
			@if(Auth::user()->id <> $post->user_id)
				<form method="POST" action="{{action('PostController@point')}}">
				    @csrf
				    @method('PUT')
				    <input type="hidden" name="data[0]" value="{{$voted}}">
				    <input type="hidden" name="data[1]" value="{{$post->id}}">
				    <input type="submit" value="投票" class="btn btn-success"></input>
				</form>
			@endif
			@if(Auth::user()->id == $post->user_id)
			<a href="{{ action('PostController@edit', $post->id) }}"  class="btn btn-primary">修正</a>
			@endif
		@endguest
		</div>
		@guest
		@else
			@if(Auth::user()->id == $post->user_id)
				@foreach($comments as $comment)
					@if($comment->post_id == $post->id)
					<div class="card-footer">
						<p class="card-text">{!! nl2br(e($comment->body)) !!}</p>
						<p class="card-text">投稿日時：{{$comment->created_at}}　更新日時：{{$comment->updated_at}}</p>
					</div>
					@endif
				@endforeach
			@endif
		@endguest
	</div>
	<?php $i = $i + 1 ?>
	@endforeach
</div>
@endsection