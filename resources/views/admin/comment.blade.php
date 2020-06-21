@extends('layouts.admin.app')

@section('content')
<div class="container">
	<h1>コメント追加</h1>
 	管理人のコメント追加ページです。
 	<form method="POST" action="{{ action('AdminCommentController@store', $post->id) }}">
 		@csrf
 		<div class="form-group">
 			<label for="body">コメント投稿欄</label>
 			<textarea class="form-control" id="body" name="body" rows="2"></textarea>
 		</div>
 		<button type="submit" class="btn btn-primary">コメント作成</button>
 	</form>

	<div class="card">
		<div class="card-body">
		 	<h5>{!! nl2br(e($post->body)) !!}</h5>
			<p class="card-text">投稿者：{{$post->user->family_name}}　{{$post->user->haiku_name}}　都道府県：{{$post->user->prefecture}}　得票：{{$post->point}}</p>
			<p class="card-text">投稿日時：{{$post->created_at}}　更新日時：{{$post->updated_at}}</p>
		</div>
		@foreach($comments as $comment)
			@if($comment->post_id == $post->id)
			<div class="card-footer">
				<p class="card-text">{!! nl2br(e($comment->body)) !!}</p>
				<p class="card-text">投稿日時：{{$comment->created_at}}　更新日時：{{$comment->updated_at}}</p>
				<a href="{{ action('AdminCommentController@edit', [
				'post_id' => $post->id,
				'comment_id' =>$comment->id,
				]) }}"  class="btn btn-primary">コメント修正</a>
			</div>
			@endif
		@endforeach
	</div>
</div>
@endsection