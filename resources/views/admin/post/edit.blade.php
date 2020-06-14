@extends('layouts.admin.app')

@section('content')
<div class="container">
 	<h1>俳句修正</h1>
 	<p>俳句の修正は1句につき2回までです。</p>
 	<p>この俳句は後{{$post->correct_time}}回修正できます。</p>
 	<form method="POST" action="{{ action('AdminPostController@update', $post->id) }}">
 		@csrf
 		@if (count($errors) > 0)
			    @foreach ($errors->all() as $error)
			        {{ $error }}
			    @endforeach
		@endif
 		<div class="form-group">
 			<label for="body">投句修正欄</label>
 			<textarea class="form-control" id="body" name="body" rows="2">{{ $post->body }}</textarea>
 		</div>
 		<button type="submit" class="btn btn-primary">修正確定</button>
 	</form>
	<a href="{{ action('AdminPostController@index') }}"  class="btn btn-secondary">戻る</a>
	@foreach($comments as $comment)
		@if($comment->post_id == $post->id)
		<div class="card-footer">
			<p class="card-text">{!! nl2br(e($comment->body)) !!}</p>
			<p class="card-text">投稿日時：{{$comment->created_at}}　更新日時：{{$comment->updated_at}}</p>
		</div>
		@endif
	@endforeach
</div>
@endsection