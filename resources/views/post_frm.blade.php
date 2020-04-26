<form>
    <div class="form-group">
        <label for="title" class="control-label">Title:</label>
        <input type="text" class="form-control" id="title" name="title" value="{{$post->title ?? ''}}">
        <span class="text-danger" id="title_error"></span>
    </div>
    <input type="hidden" id="post_id" name="id" value="{{$post->id ?? ''}}">
    @csrf
    <div class="form-group">
        <label for="sort_description" class="control-label">Sort Description:</label>
        <textarea class="form-control" id="sort_description" name="sort_description">{{$post->sort_description ?? ''}}</textarea>
        <span class="text-danger" id="sort_description_error"></span>
    </div>
    <div class="form-group">
        <label for="description" class="control-label">Description:</label>
        <textarea class="form-control" id="description" name="description">{{$post->description ?? ''}}</textarea>
        <span class="text-danger" id="description_error"></span>
    </div>
    <div class="form-group">
        <label for="category" class="control-label">Category:</label>
        @if(!empty($post->category) && count($post->category))
            @php $selectedCategory = array_column($post->category->toArray(),'category_id'); @endphp
        @endif
        <select class="form-control" id="category" name="category[]" multiple="">
            @if(!empty($category))
                @foreach($category as $cat)
                    <option value="{{$cat->id}}" {{ !empty($selectedCategory) && in_array($cat->id, $selectedCategory) ? 'selected' : ''}}>{{$cat->name}}</option>
                @endforeach
            @endif
        </select>
        <span class="text-danger" id="category_error"></span>
    </div>
    <div class="form-group">
        <label for="image" class="control-label">Select Image</label>
        <input id="image" type="file" class="image" name="image">
        <span class="text-danger" id="image_error"></span>
        <input type="hidden" name="old_image" id="old_image" value="{{$post->image ?? ''}}">
        @if(!empty($post->image))
            <img src="{{asset('public/images/post/'.$post->image)}}" style="width: 80px; height: 80px;">
        @endif
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-defaul" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="save_post">Save Post</button>
        <div class="submit_notification"></div>
    </div>
</form>