<?php
    /**
     * @var BlogPost $post
     */

use App\Models\BlogPost;

?>
@extends('layouts.app')

@section('title', $post->title)

@section('content')

    @if($post->image)
        <div style="background-image: url('{{$post->image->url()}}'); min-height: 500px; color: white;
            text-align: center; background-attachment: fixed">
            <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
    @else
        <h1>
    @endif
    {{ $post->title }}
        @if($post->image)
            </h1>
        </div>
        @else
        </h1>
        @endif
    <p>{{ $post->content }}</p>
{{--    <img src="{{$post->image->url()}}" alt="">--}}
    {{--  How much time has passed since  --}}
    <p>Added {{$post->created_at->diffForHumans()}}</p>
    {{-- now() generates the carbon object with current time --}}
    @if(now()->diffInMinutes($post->created_at) < 5)
        @badge(['type' => 'primary'])
            New!
        @endbadge
    @endif
    <h4>Comments</h4>
    @forelse($post->comments as $comment)
        <p>{{$comment->content}},</p>
        <p class="text-muted"> added {{$comment->created_at->diffForHumans()}}</p>
    @empty
        <p>No comments yet!</p>
    @endforelse
@endsection
