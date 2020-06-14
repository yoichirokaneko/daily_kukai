@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>今週の結果発表</h1>
 	今週の結果発表です。

	<?php $i = 1 ?>
	@foreach($posts as $post)
	<div class="card">
		<div class="card-body">
		<h5><?php echo $i ?>：{!! nl2br(e($post->body)) !!}</h5>
		<p class="card-text">投稿者：{{$post->user->name}}　都道府県：{{$post->user->prefecture}}　得票：{{$post->point}}</p>
		<p class="card-text">投稿日時：{{$post->created_at}}　更新日時：{{$post->updated_at}}</p>
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
	<?php $i = $i + 1 ?>
	@endforeach
</div>
@endsection