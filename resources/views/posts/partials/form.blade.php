<div class="form-group">
    <label for="title">Title</label>
    <input id="title" type="text" name="title" class="form-control" value="{{old('title', optional($post ?? null)->title)}}">
</div>
@error('title')
<div class="alert alert-danger">{{$message}}</div>
@enderror
<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" class="form-control" name="content">{{old('content', optional($post ?? null)->content)}}</textarea>
</div>
<div class="form-group">
    <label for="fileThumbnail">Thumbnail</label>
    <input id="fileThumbnail" type="file" name="thumbnail" class="form-control-file">
</div>
@if($errors->any)
    <div class="mb-3">
        <ul class="list-group">
            @foreach($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
