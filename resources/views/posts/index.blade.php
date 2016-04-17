@extends('layouts.app')

@section('title') All Posts @endsection


@section('content')

<div class="row">
	<div class="col-md-9">
		<h1 style="margin-left: 150px;">All Posts</h1>
	</div>

	<div class="col-md-2">
		<a href="{{ route('posts.create') }}" class="btn btn-lg btn-block btn-primary" style="margin-top: 18px;">Create New Post </a>
	</div>
	<hr>
	
</div>

@endsection
