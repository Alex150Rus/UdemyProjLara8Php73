@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    @foreach($posts as $post)
        <div>{{ $post['title'] }}</div>
    @endforeach
@endsection
