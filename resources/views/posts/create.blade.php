@extends('layouts.app')

@section('title', '|Create New Post @endsection')


@section('content')
<div class="row">

	<div class="col-md-8 col-md-offset-2">
	@if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif
		<h1>Create New Post</h1>
		<hr>
			{{ Form::open(array('route' => 'posts.store')) }}

    		<div class="form-group">
        	{{ Form::label('title', 'Title') }}
        	{{ Form::text('title', null, array('class' => 'form-control')) }}<br>

        	{{ Form::label('body', 'Post Body') }}
        	{{ Form::textarea('body', null, array('class' => 'form-control')) }}<br>

        	{{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg btn-block')) }}

        	{{ Form::close() }}
    </div>
	</div>
</div>


@endsection