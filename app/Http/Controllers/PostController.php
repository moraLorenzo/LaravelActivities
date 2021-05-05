<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        //Only authenticated users can access this feature
        $this->middleware('auth')->only('create');
        $this->middleware('auth')->only('update');
        $this->middleware('auth')->only('destroy');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Navigates to post page
        $user = User::find(Auth::id()); 
        $posts = $user->posts()->orderBy('created_at','desc')->get();
        $count = $user->posts()->where('title','!=','')->count();
        return view('post.post', compact('posts', 'count'));
        
    }  
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Navigate to create.blade.php

        return view('post.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Fetching requests and posting it on the db
        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'description' => 'required'
        ]);
        
        if($request->hasFile('img')){

            $filenameWithExt = $request->file('img')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('img')->getClientOriginalExtension();

            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            $path = $request->file('img')->storeAs('public/img', $fileNameToStore);
        } else{
            $fileNameToStore = '';
        }

        $post = new Post();
        $post->fill($request->all());
        $post->img = $fileNameToStore;
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //Shows a specific data row to show
        $post = $post->id;
        $show = Post::where('id', $post)->get();
        // dd($show);

        return view('post.show', compact('show'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //edit a data row

        $edit = Post::find($post);

        return view('post.edit', compact('edit'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $post = Post::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return redirect('/posts');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete a certain data row
        $post = Post::find($id);
        $post->delete();

        return redirect('/posts');

    }
    
}
