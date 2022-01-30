<?php
    /**
     * @var BlogPost $post
     */

use App\Models\BlogPost;

?>
@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <img src="{{$post->image->url()}}" alt="">
    {{--  How much time has passed since  --}}
    <p>Added {{$post->created_at->diffForHumans()}}</p>
    {{-- now() generates the carbon object with current time --}}
    @if(now()->diffInMinutes($post->created_at) < 5)
        <div class="alert alert-info">New!</div>
    @endif
    <h4>Comments</h4>
    @forelse($post->comments as $comment)
        <p>{{$comment->content}},</p>
        <p class="text-muted"> added {{$comment->created_at->diffForHumans()}}</p>
    @empty
        <p>No comments yet!</p>
    @endforelse
@endsection
