<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

//how Laravel knows which policy to use, if we don't tell the ability name? It uses method name map
//[
//    'show' => 'view',
//    'create' => 'create',
//    'store' => 'create',
//    'edit' => 'update',
//    'update' => 'update',
//    'destroy' => 'delete',
//]
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
        return view(
            'posts.index',
            [
                'posts' => BlogPost::latest()->withCount('comments')->get(),
                'mostCommented' => BlogPost::mostCommented()->take(5)->get(),
                'mostActive' => User::withMostBlogPosts()->take(5)->get(),
            ]
        );
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
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);

        if($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            $post->image()->save(
                Image::create([
                    'path' => $path,
                ])
            );
        }

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

//        return view(
//            'posts.show',
//            ['post' => BlogPost::with(['comments' => function($query) {
//                return $query->latest();
//            }])->findOrFail($id)]
//        );
        return view(
            'posts.show',
            ['post' => BlogPost::with('comments')->findOrFail($id)]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
//        if (Gate::denies('update-post', $post)) {
//            abort(403, "You can't edit this blog post");
//        }
        //instead of gate
       //$this->authorize('posts.update', $post);
        //$this->authorize('update', $post);
        //works even without ability
        $this->authorize($post);

        return view('posts.edit', ['post' => $post]);
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

//        if (Gate::denies('update-post', $post)) {
//            abort(403, "You can't edit this blog post");
//        }
        //instead of gate
        //$this->authorize('posts.update', $post);
        $this->authorize('update', $post);

        $validated = $request->validated();
        $post->fill($validated);

        if($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');

            if($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::create([
                        'path' => $path,
                    ])
                );
            }
        }

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

//        if (Gate::denies('delete-post', $post)) {
//            abort(403, "You can't delete this blog post");
//        }
        //instead of gate
        //$this->authorize('posts.delete', $post);
        $this->authorize('delete', $post);

        $post->delete();

        session()->flash('status', 'Blog post was deleted!');
        return redirect()->route('posts.index');
    }
}
