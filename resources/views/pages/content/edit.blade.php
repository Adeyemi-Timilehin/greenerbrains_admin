@extends('layouts.default')

@section('title')
Edit Content
@endsection

@section('content')
<script src="https://cdn.plyr.io/3.5.10/plyr.js"></script>
<link rel="stylesheet" href="https://cdn.plyr.io/3.5.10/plyr.css" />

<div class="kt-pagetitle">
  <h5>Content Editor</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
  @if(Session::has('error'))
  <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{!! Session::get('error') !!}</p>
  @endif

  @if(Session::has('success'))
  <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
  @endif
  {{-- 
  @if ($errors->any())
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
  @endforeach
  </ul>
</div>
@endif --}}
<form id="content-form" action="{{ route('update-content',$content->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  {{-- @method('PUT') --}}
  <div class="card pd-20 pd-sm-40">
    <p class="mg-b-20 mg-sm-b-30">
      <span style="color:red;">*</span> Marked fields are required.
    </p>
    <div class="form-layout">
      <div class="row mg-b-25">
        <div class="col-lg-6">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Category:
              <span class="tx-danger">*</span></label>
            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select Content Type"
              aria-hidden="true" id="category" name="category" required>
              <option label="Select Category" disabled>Select Category</option>
              @foreach($categories as $item)
              <option value="{{ $item->name }}"
                {{ $content->category == $item->name || $content->category == $item->id ? 'selected' : '' }}>
                {{ $item->label}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- col-4 -->
        <div class="col-lg-6">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Content Access:
              <span class="tx-danger">*</span></label>
            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select access type"
              id="content_access" name="content_access" value="{{ $content->content_access }}" required>
              <option label="Select access type" disabled></option>
              @foreach($accesses as $item)
              <option value="{{ $item->name }}" {{ $content->content_access == $item->name ? 'selected' : '' }}>
                {{ $item->label}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- col-4 -->
        <!-- col-4 -->
        {{-- <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Content Tags:
                  <span class="tx-danger">*</span></label>
                <div id="cbWrapper" class="parsley-checkbox">
                  @foreach($tags as $item)
                  <label class="ckbox" style="display:inline-block;">
                    <input type="checkbox" value="{{ $item->id }}" id="tags" name="tags[]"
        data-parsley-multiple="browser"><span>{{ $item->label }}</span>
        </label>
        @endforeach
      </div>
      <a href="/admin/tag/create" rel="noopener noreferrer">Add new tags</a>
    </div>
  </div> --}}
  <!-- col-4 -->
  </div>
  <!-- row -->
  </div>
  </div>
  <!-- card -->

  <div class="card pd-20 pd-sm-40 mg-t-10 pd-b-40 pb-4">
    <div class="form-layout">
      <div class="row mg-b-25">

        <!-- col-4 -->
        <div class="col-lg-6">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Subject:
              <span class="tx-danger">*</span></label>
            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select Content Type"
              aria-hidden="true" id="subject_id" name="subject_id" required>
              <option label="Select Subject" disabled>Select Subject</option>
              @foreach($subjects as $item)
              <option value="{{ $item->id }}">{{ $item->label}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Title: <span class="tx-danger">*</span></label>
            <input class="form-control select2 select2-hidden-accessible" type="text" name="title" id="title"
              name="title" value="{{ $content->title }}" placeholder="Resolved Issues At Creating New Display Board"
              required />
          </div>
        </div>

      </div>
    </div>
    <br />
    <div id="editor_box">
      <div class="col-lg-12">
        <div class="form-group mg-b-10-force">
          <!-- col-12 -->
          <label class="form-control-label">
            Body: <span class="tx-danger">*</span>
          </label>

          <!-- The toolbar will be rendered in this container. -->
          <div id="toolbar-container"></div>

          <!-- This container will become the editable. -->
          <div id="editor" style="height: 300px; border: 1px solid rgba(68, 68, 68, 0.26);">
            {!! $content->body !!}
          </div>
          <textarea rows="3" class="hidden form-control select2 select2-hidden-accessible" name="body" id="body"
            style="height: 300px; width: 100%; border: 1px solid rgba(68, 68, 68, 0.26);">{!! $content->body !!}</textarea>
        </div>
      </div>

      <script>
        DecoupledEditor.create(document.querySelector("#editor"))
          .then(editor => {
            const toolbarContainer = document.querySelector(
              "#toolbar-container"
            );

            toolbarContainer.appendChild(
              editor.ui.view.toolbar.element
            );
          })
          .catch(error => {
            console.error(error);
          });
      </script>
    </div>
  </div>
  <!-- card -->



  <div class="card pd-20 pd-sm-40 mg-t-10">
    <div class="form-layout">
      <div class="row mg-b-25">
        
        @if (isset($content->thumbnail ))
        <div class="col-sm-4">
          <div class="form-group mg-b-10-force border bordered">
            <img src="{{ $content->thumbnail }}" title="content thumbnail photo" style="width:100%; height: 265px;">
          </div>
        </div>
        @endif

        @if (isset($content->media ))
        <div class="col-sm-8 offset-sm-1">
          <div style="text-align:center">
            @if(isset($content->media))
            @if(isset($content->media->url))
            <video id="my-player" class="video-js" controls preload="auto" poster="{{ $content->media->thumbnail }}"
              data-setup='{}' style="width:100%; max-width: 100%; max-height: 265px;">
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
        @endif
        
        <!-- col-4 -->
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Thumbnail: <span class="tx-danger">*</span></label>
            <!-- <label class="custom-file"> -->
            <input type="file" accept="image/*" id="thumbnail" name="thumbnail"
              class="form-control select2 select2-hidden-accessible" />
            <!-- <span class="custom-file-control"></span> -->
            <!-- </label> -->
          </div>
        </div>

        <!-- col-4 -->
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Media Source:</label>
            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select Media Source"
              tabindex="-1" aria-hidden="true" id="media_source" name="media_source">
              <option label="Select Media Source" disabled>-- Select video source --</option>
              <option value="internal" selected>Upload from Device</option>
              <option value="external">External</option>
            </select>
          </div>
        </div>
        <!-- col-4 -->

        <!-- col-4 -->
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Video:
              <span class="tx-danger">*</span></label>
            <!-- <label class="custom-file"> -->
            <input type="file" accept="video/*" id="media" name="media"
              class="form-control select2 select2-hidden-accessible" />
            <input type="text" id="media_url" name="media_url" class="form-control select2 select2-hidden-accessible" />
            <!-- <span class="custom-file-control"></span> -->
            <!-- </label> -->
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="card pd-20 pd-sm-40 mg-t-10">
    <div class="form-layout">
      <div class="row mg-b-25">
        <!-- col-4 -->
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Rating: </label>
            <input class="form-control select2 select2-hidden-accessible" type="number" max="5" min="1" placeholder="1"
              name="rating" id="rating" aria-hidden="true" value="{{ $content->rating }}" />
          </div>
        </div>
        <!-- col-4 -->
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Publish Date:
            </label>
            <input type="datetime-local" class="form-control" placeholder="MM/DD/YYYY" id="publish_date"
              name="published_date" value="{{ $content->created_at }}" />
          </div>
        </div>
        <!-- col-4 -->

        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Public view status: </label>
            <label class="ckbox">
              <input type="checkbox" checked id="publish" name="publish" value="{{ $content->is_published}}" />
              <span>Publish Content</span>
            </label>
          </div>
        </div>
        <!-- col-4 -->
      </div>
      <!-- row -->

      <hr>

      <div class="form-layout-footer">
        <button class="btn btn-primary mg-r-5" type="submit" id="submit-btn">
          Save Update
        </button>
        <button class="btn btn-danger" type="reset">
          Cancel
        </button>
      </div>
      <!-- form-layout-footer -->
    </div>
  </div>
  <!-- card -->
</form>
</div>
<!-- <script src="{{ asset('lib/medium-editor/medium-editor.js') }}"></script> -->
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
  document.addEventListener("DOMContentLoaded", event => {
    window.Axios = axios;
    let category_field = document.getElementById("category");
    let title_field = document.getElementById("title");
    let content_type_field = document.getElementById("content_type");
    let media_source = document.getElementById("media_source");
    let access_type_field = document.getElementById("content_access");
    let editor_box = document.getElementById("editor_box");
    let media_box = document.getElementById("media_box");
    let publish_date_field = document.getElementById("publish_date");
    let publish_field = document.getElementById("publish");
    let rating_field = document.getElementById("rating");
    let editor = document.getElementById("editor");
    let body = document.getElementById("body");
    let media_field = document.getElementById("media");
    let media_url = document.getElementById("media_url");
    let submit_btn = document.getElementById("submit-btn");
    let content_form = document.getElementById("content-form");
    let file = null;

    editor.addEventListener("keydown", e => {
      body.value = editor.innerHTML;
    });

    content_form.addEventListener("submit", e => {
      // e.preventDefault();
      body.value = editor.innerHTML;
      // submit();
    });

    // content_type_field.addEventListener("change", () => {
    //     if (content_type_field.value == "text") {
    //         editor_box.style = "display: inline;";
    //         media_box.style = "display: none;";
    //     } else if (content_type_field.value == "video") {
    //         editor_box.style = "display: none;";
    //         media_box.style = "display: flex";
    //     }
    // });

    // Initial default
    // media.style = "display: none;";
    media_url.style = "display: none;";
    // editor_box.style = "display: none;";
    // media_box.style = "display: none;";

    media_source.addEventListener("change", () => {
      if (media_source.value == "external") {
        media_url.style = "display: inline;";
        media.style = "display: none;";
        media.setAttribute("hidden", true);
        media_url.removeAttribute("hidden");
      } else if (media_source.value == "internal") {
        media.style = "display: inline;";
        media_url.style = "display: none;";
        media.removeAttribute("hidden");
        media_url.setAttribute("hidden", true);
      }
    });
    // default to file upload
    media_url.style = "display: none;";
    media_url.setAttribute("hidden", true);
  });
</script>
@stop