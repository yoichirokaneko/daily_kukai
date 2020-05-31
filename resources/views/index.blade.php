@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>俳句一覧</h1>
 	投句はログインユーザーでなければ行えません。
 	１週間の中で1人５句まで投稿できます。
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
							echo ' bg-warning';
							$voted = 1;
						}
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
			<a href="{{ action('PostController@edit', $post->id) }}"  class="btn btn-primary">編集</a>
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
						<p class="card-text">投稿日時：{{$post->created_at}}　更新日時：{{$post->updated_at}}</p>
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