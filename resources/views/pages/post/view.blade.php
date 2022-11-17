@extends('layouts.default')

@section('title')
View Post
@endsection

@section('content')
<div class="kt-pagetitle">
  <h5>@yield('title')</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
  @if(Session::has('error'))
  <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{!! Session::get('error') !!}</p>
  @endif

  @if(Session::has('success'))
  <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
  @endif

  <div class="card pd-20 pd-sm-40">
    <div class="form-layout">
      @if (isset($post))
      
          <h2>{{ $post->title }}</h2>
          <hr class="p-2" />
          <br>
          <div class="row tx-roboto">
            @if (isset($post->image))
               <div class="col-sm-12">
                 <img class="img-thumbnail" width="80%" src="{{ isset($post->image) ? $post->image : '' }}" alt="{{ $post->title ? $post->title : '' }}">
                 <hr class="p-20">
                </div> 
               
            @endif
            
            <dt class="col-sm-3 tx-inverse">Title</dt>
            <dd class="col-sm-9">{{ isset($post->title) ? $post->title : '' }}</dd>

            <dt class="col-sm-3 tx-inverse">Comments</dt>
            <dd class="col-sm-9">{{ isset($post->comments) ? count($post->comments) : '' }}</dd>

            <dt class="col-sm-3 tx-inverse">Views</dt>
            <dd class="col-sm-9">{{ isset($post->views) ? $post->views : '0' }}</dd>

            <dt class="col-sm-3 tx-inverse">Likes</dt>
            <dd class="col-sm-9">{{ isset($post->likes) ? $post->likes : '0' }}</dd>

            <dt class="col-sm-3 tx-inverse">Publisher</dt>
            <dd class="col-sm-9">{{ isset($post->user) ? $post->user->name : '' }}</dd>

            <dt class="col-sm-3 tx-inverse">Date Created</dt>
            <dd class="col-sm-9">{{ isset($post->created_at) ? $post->created_at->diffForHumans() : '' }}</dd>

            <dt class="col-sm-3 tx-inverse">Date Updated</dt>
            <dd class="col-sm-9" class="col-sm-9">
              {{ isset($post->updated_at) ? $post->updated_at->diffForHumans() : '' }}</dd>

            <dt class="col-sm-3 tx-inverse">Tags</dt>
            <dd class="col-sm-9" class="col-sm-9">
              @if (isset($post->tags))
              @for ($j = 0; $j < count($post->tags); $j++)
                <span class="badge badge-primary square">{{ ($post->tags) ? $post->tags[$j]->label : '' }}</span>
                @endfor
                @endif
            </dd>
          </div>
        {{-- </div> --}}
        <hr class="p-2" />
        <!-- </div> -->
        <!-- col-4 -->

        @if (isset($post->body) && $post->body !== '')
        <div class="col-12">
          <h4>Body</h4>
          <hr>
          {!! $post->body !!}
        </div>
        @endif

        @if (isset($post->comments))
        <div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
          <div class="card">
            <div class="card-header" role="tab" id="headingOne">
              <h6 class="mg-b-0">
                <a style="background-color: #6CC091;" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="tx-gray-800 transition">
                  Post Comments - {{ count($post->comments) }}
                </a>
              </h6>
            </div><!-- card-header -->

            <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" style="">
              <div class="card-body">
                @foreach ($post->comments as $comment)
                <div class="list-group-item">
                  <div class="media">
                    <img src="{{ $comment->user ? $comment->user->image : '../img/avatar.jpg' }}" class="wd-30 rounded-circle" alt="">
                    <div class="media-body mg-l-10">
                      <h6 class="mg-b-0 tx-inverse tx-13">{{ isset($comment->user) ? $comment->user->name : '' }}</h6>
                      <p class="mg-b-0 tx-gray-500 tx-12">{{ isset($comment->created_at) ? $comment->created_at->diffForHumans() : '' }}</p>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <p class="mg-t-10 mg-b-0 tx-13">{{ isset($comment->comment) ? $comment->comment : '' }}</p>
                  <a href="{{ $comment->published ? route('comment.unpublish', ['id' => $comment->id]) : route('comment.publish', ['id' => $comment->id]) }}" type="button" class="btn {{ $comment->published ? 'btn-danger' : 'btn-primary' }}">
                    <i class="fa {{ $comment->published ? 'fa-lock' : 'fa-unlock' }} mg-r-10"></i> 
                    {{ $comment->published ? 'Unpublish Comment' : 'Publish Comment' }}
                  </a>
                </div>   
                @endforeach
                
                <!-- list-group-item -->
              </div><!-- list-group -->
                
              </div>
            </div>
          </div>
        </div>
        @endif

        @if (isset($post->id))
        <div class="col-lg-12 mg-t-0">
          <hr>
          <div class="form-group mg-b-0-force">
            <a href="{{ route('post.edit', ['id' => $post->id, 'post' => $post ]) }}" class="btn btn-info mg-r-5">Edit
              Post</a>
          </div>
        </div>
        @endif

      </div>

      @endif
  </div>
  <!-- card -->
</div>

@stop