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

    @badge(['show' => now()->diffInMinutes($post->created_at) < 5])
    New!
    @endbadge

        @if($post->image)
            </h1>
        </div>
        @else
        </h1>
        @endif
    <p>{{ $post->content }}</p>

    @updated(['date' => $post->created_at, 'name' => $post->user->name])
    @endupdated

    @updated(['date' => $post->updated_at])
    Updated
    @endupdated

    <h4>Comments</h4>
    @forelse($post->comments as $comment)
        <p>{{$comment->content}},</p>
        @updated(['date' => $comment->created_at])
        @endupdated
    @empty
        <p>No comments yet!</p>
    @endforelse
@endsection
