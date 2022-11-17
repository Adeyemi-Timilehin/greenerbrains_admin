@extends('layouts.default') 

@section('title')
View Content
@endsection

@section('content')
<div class="kt-pagetitle">
    <h5>Content Editor</h5>
</div>
<script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.10/plyr.css" />
<style>
  video,
  #my-player {
    width: 100%;
    max-width: 100%;
    max-height: 100vh;
  }
</style>


<!-- kt-pagetitle -->

<div class="kt-pagebody">
    @if(Session::has('error'))
    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{!! Session::get('error') !!}</p>
    @endif

    @if(Session::has('success'))
    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
    @endif
    
    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif --}}

    @if (isset($content))
    <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">{{ $content->title }}</h6>
        <p class="mg-b-20 mg-sm-b-30">
            Created {{ $content->created_at->diffForHumans() }}
        </p>
        <div class="row tx-roboto">
            <dt class="col-sm-3 tx-inverse">Category</dt>
            <dd class="col-sm-9">
              @if ($content->contentCategory)
                <a href="{{ route('show-category', ['id' => $content->contentCategory->id]) }}">
                  {{ $content->contentCategory ? $content->contentCategory->label : '' }}
                </a>
              @else
                  Not Specified!
              @endif
            </dd>
            <dt class="col-sm-3 tx-inverse">Subject</dt>
            <dd class="col-sm-9"> 
              @if ($content->subject)
                <a href="{{ route('show-subject', ['id' => $content->subject->id]) }}">
                  {{ $content->subject ? $content->subject->label : '' }}
                </a>
              @else
                  Not Specified!
              @endif
            </dd>
            <dt class="col-sm-3 tx-inverse">Rating</dt>
            <dd class="col-sm-9">{{ $content->rating }}</dd>
            <!-- <dt class="col-sm-3 tx-inverse">Position</dt>
            <dd class="col-sm-9">{{ $content->position ? $content->position : '-' }}</dd> -->
            <!-- <dt class="col-sm-3 tx-inverse">Topic</dt>
            <dd class="col-sm-9">{{ $content->topic ? $content->topic : '-' }}</dd> -->
            <dt class="col-sm-3 tx-inverse">Status</dt>
            <dd class="col-sm-9">{{ $content->is_published ? 'Published' : 'Not Published' }}</dd>
            @if (isset($content->is_published) )
            <dt class="col-sm-3 tx-inverse">Publish Date</dt>
            <dd class="col-sm-9">{{ $content->published_date ? $content->published_date : '-' }}</dd>
            @endif

            <hr class="hr-primary">

            <div class="col-sm-4">
                <span class="tx-uppercase tx-12 tx-medium d-block mg-b-15">Media Content</span>


                <div class="display-1 pd-10 mt-4 bg-gray-200 tx-inverse tx-center mg-b-15">
                    <img src="{{ $content->media ? $content->media->thumbnail : null }}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
                    <span class="tx-uppercase tx-medium tx-12 d-block mb-15 mt-3">Thumbnail</span>
                </div>

            </div>
            <!-- col-4 -->
            <div class="col-sm offset-sm-1">
                <div style="text-align:center">
                    <br><br>
                    @if(isset($content->media))
                        @if(isset($content->media->url))
                        {{-- <div id="player"></div> --}}
                        {{-- <iframe width="560" height="315" src="https://www.youtube.com/embed/GC80Dk7eg_A" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                        {{-- <iframe width="560" height="315" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                        {{-- <iframe src="{{$content->media->url}}" frameborder="0" style="width:100%; height: 265px;" poster="{{$content->media->thumbnail}}" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                        <video id="my-player" class="video-js" controls preload="auto"
                          poster="{{ $content->media->thumbnail }}"
                          data-setup='{}'
                          style="width:100%; max-width: 100%; max-height: 265px;">
                          <source src="{{ $content->media->url }}" type="video/mp4">
                          </source>
                          <source src="{{ $content->media->url }}" type="video/webm">
                          </source>
                          <source src="{{ $content->media->url }}" type="video/ogg">
                          </source>
                          <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that
                            <a href="{{ route('content') }}">
                              View Courses
                            </a>
                          </p>
                        </video>
                        @endif
                    @endif
                    <span class="tx-uppercase tx-medium tx-12 d-block mg-b-15">Uploaded file</span>
                </div>

            </div>
        </div>
        <!-- row -->

        <div class="row mb-20">
            <div class="col-12">
                <div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingTwo">
                            <h6 class="mg-b-0">
                                <a class="transition collapsed" style="background-color: #6CC091;" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Body Text <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </h6>
                        </div>
                        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                            <div class="card-body">
                                {!! html_entity_decode($content->body) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <hr class="hr-primary">

        <div class="btn-group mg-b-20 mg-t-20" role="group" aria-label="Basic example">
            <a
                type="button"
                href="/admin/content/{{ $content->id }}/edit"
                class="btn btn-secondary pd-x-25 active"
            >
                Edit <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
            <a
                type="button"
                href="/admin/content/{{ $content->id }}/delete"
                class="btn btn-danger pd-x-25 active"
            >
                Delete <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    @endif

</div>
<!-- <script src="{{ asset('lib/medium-editor/medium-editor.js') }}"></script> -->
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
  // 2. This code loads the IFrame Player API code asynchronously.
  var tag = document.createElement('script');

  // tag.src = "https://www.youtube.com/iframe_api";
  tag.src = "{{ $content->media->url }}";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // 3. This function creates an <iframe> (and YouTube player)
  //    after the API code downloads.
  var player;
  function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
      height: '390',
      width: '640',
      videoId: 'M7lc1UVf-VE',
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
  }

  // 4. The API will call this function when the video player is ready.
  function onPlayerReady(event) {
    event.target.playVideo();
  }

  // 5. The API calls this function when the player's state changes.
  //    The function indicates that when playing a video (state=1),
  //    the player should play for six seconds and then stop.
  var done = false;
  function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
      setTimeout(stopVideo, 6000);
      done = true;
    }
  }
  function stopVideo() {
    player.stopVideo();
  }
</script>

<style>
    hr {
        border-top: 1px solid #757575;
        opacity: 0.3;
        width: 100%;
        margin: 10px;
    }

</style>

@stop
