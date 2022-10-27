@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')

    {{-- , collection to loop,passing var name, optional - partial template name when collection is empty --}}
    {{-- @each('posts.partials.post', $posts, 'post')--}}
    <div class="row">
        <div class="col-8">
            @forelse($posts as $key => $post)
                {{-- include passes all variables in cycle/context into view. But it is also possible to pass additional vars via, []--}}
                @include('posts.partials.post')
            @empty
                <div>No posts found</div>
            @endforelse
        </div>
        <div class="col-4">
            <div class="container">
                <div class="row">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented</h5>
                            <h6 class="card-subtitle mb-2 text-muted">What people are currently talking about.</h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{route('posts.show', ['post' => $post->id])}}">{{ $post->title }}</a>

                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Users with most posts written.
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($mostActive as $user)
                                <li class="list-group-item">
                                   {{ $user->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
