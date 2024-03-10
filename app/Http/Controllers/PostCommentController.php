<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        $post->comments()->create([
           'user_id' => $request->user()->id,
           'content' => $request->input('content'),
        ]);

        $request->session()->flash('status', 'Comment was created');

        return redirect()->back();
    }
}