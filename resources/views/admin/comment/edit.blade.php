@extends('layouts.admin.app')

@section('content')
<div class="container">
	<h1>コメントの修正</h1>
	管理人のコメント修正ページです。
	<form method="POST" action="{{ action('AdminCommentController@update',[
	'post_id' => $post->id,
	'comment_id' =>$comment->id,
	]) }}">
 		@csrf
 		@if (count($errors) > 0)
			    @foreach ($errors->all() as $error)
			        {{ $error }}
			    @endforeach
		@endif
 		<div class="form-group">
 			<label for="body">コメント修正欄</label>
 			<textarea class="form-control" id="body" name="body" rows="2">{{ $comment->body }}</textarea>
 		</div>
 		<button type="submit" class="btn btn-primary">修正確定</button>
 	</form>
	<a href="{{ action('AdminCommentController@index', [
	'post_id' => $post->id,
	'comment_id' => $comment->id,
	]) }}"  class="btn btn-secondary">戻る</a>
</div>
@endsection