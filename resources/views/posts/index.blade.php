@extends('layouts.app')

@section('title') All Posts @endsection

@section('content')

<div class="col-lg-10 col-lg-offset-1">

    <h1><i class="fa fa-book"></i> All Posts <a href="{{ route('posts.create') }}" class="btn btn-primary pull-right">Create New Post</a></h1>
    <hr>
    <br>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Date/Time Added</th>
                    <th>Operations</th>
            </thead>

            <tbody>
            @foreach ($posts as $post)
  					<tr>
  						<th>{{ $post->id }}</th>
  						<td>{{$post->title }}</td>
  						<td>{{ substr($post->body, 0, 50) }}{{ strlen($post->body) > 50 ? "...":""}}</td>
  						<td>{{$post->created_at->format('F d, Y h:ia') }}</td>
  						<td><a href="{{ route('posts.show', $post->id) }}" class="btn btn-default btn-sm">View</a> <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-default btn-sm">Edit</a></td>
  					</tr>

  			@endforeach

  			
  				
  			</tbody>
		</table>
		
	</div>

@endsection