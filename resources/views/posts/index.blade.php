@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')

    {{-- , collection to loop,passing var name, optional - partial template name when collection is empty --}}
    @each('posts.partials.post', $posts, 'post')

{{--    @forelse($posts as $key => $post)--}}
{{--    --}}{{-- include passes all variables in cycle/context into view. But it is also possible to pass additional vars via, [] --}}
{{--    @include('posts.partials.post')--}}
{{--    @empty--}}
{{--        <div>No posts found</div>--}}
{{--    @endforelse--}}
@endsection
