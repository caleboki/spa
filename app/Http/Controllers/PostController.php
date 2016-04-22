<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;
use Auth;
use Carbon\Carbon;

class PostController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('clearance')->except('index', 'show');

        

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderby('id', 'desc')->paginate(5);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $this->validate($request, [
            'title'=>'required|max:100',
            
            'body' =>'required',
            ]
        );

        $title = $request['title'];

        $body = $request['body'];

        $post = new Post;

        $post->title = $title;

        $post->body = $body;


        $post->save();

        \Session::flash('flash_message','Article, '. $post->title.' created');

        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return view ('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->validate($request, [
            'title'=>'required|max:100',
            'body'=>'required|',
            ]);

        $post->title = $request->input('title');

        $post->body = $request->input('body');


        $post->save();

        \Session::flash('flash_message','Article, '. $post->title.' updated');

        return redirect()->route('posts.show', $post->id);


       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();
        return redirect('posts');
    }
}
