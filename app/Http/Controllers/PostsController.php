<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;


class PostsController extends Controller
{
    public function __construct() {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('posts.index', ['posts' => BlogPost::withCount('comments')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePost $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StorePost $request)
    {
        //if errors, then redirects to the page where errors occured and stop code execution

        $validated= $request->validated();
        $post = BlogPost::create($validated);

        $hasFile = $request->hasFile('thumbnail');

        if($hasFile) {
            $file = $request->file('thumbnail');

            //short cut for using Storage facade
            //$file->store('thumbnails');
            //or using Storage facade
            //Storage::disk('public')->put('thumbnails', $file);

            //using own fileName
            $file->storeAs('thumbnails', $post->id . '.' . $file->guessExtension());
            //or
            Storage::putFileAs('thumbnails', $file, $post->id . '.' . $file->guessExtension());
            //or
            Storage::disk('public')->putFileAs('thumbnails', $file, $post->id . '.' . $file->guessExtension());
        }

//        $post = new BlogPost();
//        $post->title =  $validated['title'];
//        $post->content =  $validated['content'];
//        $post->save();

        //would create a new model instance, fill all properties from input, and try immediately save the model to db.
        //We do not need call save();
        //$post2 = BlogPost::create();

        //will create Model, fill the properties, but it would not try to save model to the db. We need to save() when
        //ready. Use it when the model hase related Model which is not exists yet or we don't have values for all needed
        //properties yet
        //$post3 =BlogPost::make();

        //$post->fill([]);

        $request->session()->flash('status', 'The blog post was created');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        //abort_if(!isset($this->posts[$id]), 404);

        return view('posts.show', ['post' => BlogPost::with('comments')->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'Blog post was updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        session()->flash('status', 'Blog post was deleted!');
        return redirect()->route('posts.index');
    }
}
