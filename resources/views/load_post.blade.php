@if(!empty($posts) && count($posts))
    <div class="row">
    @foreach($posts as $post)
        <div class="col-md-6 post-section">
            <div class="post-box">
                <div class="blog-image">
                    <div class="blog-action-block">
                        <button type="button" class="btn btn-primary btn-edit" data-toggle="modal" data-target="#postModal" data-action="Edit New Post" data-url="{{route('create_post',['id'=>$post->id])}}">Edit</button>
                        <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#postModal" data-action="Edit New Post" data-url="{{route('delete_post',['id'=>$post->id])}}">&times</button>
                    </div>
                    <img src="{{asset('public/images/post/').'/'.$post->image}}" >
                    <div class="blog-title-block">
                        <a href="">
                            <h3 class="ellipsis text-capitalize">{{ $post->title ?? ''}}</h3>
                        </a>
                        <p class="text-capitalize">{{ date('M d, Y', strtotime($post->created_at)) ?? ''}} | Published By : {{ Auth::user()->name }}</p>
                    </div>
                </div>
                <div class="blog-details">
                    <div class="category-box">
                        @if(!empty($post->category))
                            @foreach($post->category as $cat)
                                <span class="badge text-capitalize">{{$cat->name}}</span>
                            @endforeach
                        @endif
                    </div>
                    <p class="text-capitalize">{{ $post->sort_description ?? ''}}</p>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@else
    <h4 class="text-center">No Post Found</h4>
@endif