@extends('layouts.app')

@section('title') View Post @endsection

@section('content')

<div class="container">
	
	<h1>{{ $post->title }}</h1>
	<hr>
	<p class="lead">{{ $post->body }} </p>
	<hr>
	{!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', $post->id] ]) !!}
	<a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
	@haspermission('Edit Post')
	<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info" role="button">Edit</a>
	@endhaspermission
	@haspermission('Delete Post')
	{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
	@endhaspermission
	{!! Form::close() !!}

</div>

@endsection