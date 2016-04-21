@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>All Posts</h3></div>
                @foreach ($posts as $post)
                <div class="panel-body">
                <li style="list-style-type:disc">
                    <a href="{{ route('posts.show', $post->id ) }}"><b>{{ $post->title }}</b><br>
                    <p class="teaser">{{ substr($post->body, 0, 100) }}{{ strlen($post->body) > 100 ? "...":""}}</p>
                    </a>
                </li>
                </div>
                
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
