<div class="mb-2 mt-2">
    @auth
    <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content"></textarea>
        </div>
        <div>
            <input type="submit" value="Add comment" class="btn btn-primary btn-block">
        </div>
    </form>
        @errors @enderrors
    @else
        <a href="{{ route('login') }}">Sign-in</a> to post comments!
    @endauth
        <hr>
</div>
