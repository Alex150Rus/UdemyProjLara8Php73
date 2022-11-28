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
                    @card(['title' => 'Most Commented'])
                        @slot('subtitle')
                            What people are currently talking about.
                        @endslot
                        @slot('items')
                            @foreach($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{route('posts.show', ['post' => $post->id])}}">{{ $post->title }}</a>

                                </li>
                            @endforeach
                        @endslot
                    @endcard
                </div>
                <div class="row mt-4">
                    @card(['title' => 'Most Active'])
                        @slot('subtitle')
                            Users with most posts written.
                        @endslot
                        @slot('items', collect($mostActive)->pluck('name'))
                    @endcard
                </div>
                <div class="row mt-4">
                    @card(['title' => 'Most Active Last Month'])
                        @slot('subtitle')
                            Users with most posts written last month.
                        @endslot
                        @slot('items', collect($mostActiveLastMonth)->pluck('name'))
                    @endcard
                </div>
            </div>
        </div>
    </div>
@endsection
