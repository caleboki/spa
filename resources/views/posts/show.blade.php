@extends('layouts.app')

@section('title') View Post @endsection

@section('content')

<div class='col-lg-4 col-lg-offset-4'>
	
	<h1>{{ $post->title }}</h1>
	<p class="lead">{{ $post->body }} </p>
</div>

@endsection