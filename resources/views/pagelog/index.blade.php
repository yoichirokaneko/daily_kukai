@extends('layouts.app')

@section('content')
	<div class="container">	
		<ul>
		<?php $id = 1?>
			@foreach($pagelogs as $pagelog)
				<li><a href="{{ action('PastController@show', [
					'id' =>$id,
					'pagetitle' => $pagelog->title,
				]) }}">{{ $pagelog->title }}</a></li>
				<?php $id = $id + 1 ?>
			@endforeach
		</ul>
	</div>
@endsection