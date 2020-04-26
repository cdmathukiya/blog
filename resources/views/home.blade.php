@extends('layouts.app')

@section('content')
<div class="container">
    <div class="">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Blog Post</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-10">
                            <form name="filter" id="filter_table">
                                <label>Filter By : </label>
                                <input type="text" name="created_at" placeholder="Created at" class="filter_change datepicker" id="datepicker">
                                @csrf
                            </form>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postModal" data-action="Create New Post" data-url="{{route('create_post')}}">Add New Post</button>
                        </div>
                    </div>
                    <hr>
                    <div class="post-list" id="load_table">
                        <h4 class="text-center">No Post Found</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="postModal" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="postModalLabel">New message</h4>
            <button type="button" class="close" id="close_modal" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    var savePostUrl = "{{ route('save_post') }}";
    var loadPostUrl = "{{ route('load_post') }}";
    
</script>
@endsection
