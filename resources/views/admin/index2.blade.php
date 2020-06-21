@extends('layouts.admin.app')

@section('content')
<div class="container">
 	<h1>今週の結果発表</h1>
 	今週の結果発表です。

	@foreach($posts as $post)
	<div class="card">
		<div class="card-body">
		<h5>{{$post->post_no}}：{!! nl2br(e($post->body)) !!}</h5>
		<p class="card-text">
			投稿者：{{$post->user->family_name}}　{{$post->user->haiku_name}}　都道府県：{{$post->user->prefecture}}　得票：{{$post->point}}　
			@foreach($vote_logs as $vote_log)
				@if($vote_log->post_id == $post->id)
					{{$vote_log->user->haiku_name}}　
				@endif
			@endforeach
		</p>
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
	@endforeach
</div>
@endsection