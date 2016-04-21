@extends('layouts.app')

@section('title') View Post @endsection

@section('content')

<div class="container">
	
	<h1>{{ $post->title }}</h1>
	<hr>
	<p class="lead">{{ $post->body }} </p>
	<hr>
	@role('Admin')
	{!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', $post->id] ]) !!}
	<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info" role="button">Edit</a>
    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
	@else
	<a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
	@endrole

</div>

@endsection