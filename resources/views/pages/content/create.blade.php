@extends('layouts.default') 

@section('title')
Add Content
@endsection

@section('content')
<div class="kt-pagetitle">
  <h5>Content Creator</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
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

  <form id="content-form" action="{{ route('content-upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- @if(isset($success))
        <h1>Success</h1>
        <script>
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your content has been saved",
            showConfirmButton: false,
            timer: 1500
          });
        </script>
        @endif --}}
    <div class="card pd-20 pd-sm-40">
      <p class="mg-b-20 mg-sm-b-30">
        <span style="color:red;">*</span> Marked fields are required.
      </p>
      <div class="form-layout">
        <div class="row mg-b-25">
          {{-- <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Content Type:
                        <span class="tx-danger">*</span></label>
                    <select class="form-control select2 select2-hidden-accessible"
                        data-placeholder="Select Content Type" aria-hidden="true" id="content_type"
                        name="content_type" required>
                        <option label="Select Content Type" selected disabled>Select Content Type</option>
                        @foreach($content_types as $type)
                        <option value="{{ $type->name }}">{{ $type->label}}</option>
          @endforeach
          </select>
        </div>
      </div> --}}
      <!-- col-4 -->
      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">Category:
            <span class="tx-danger">*</span></label>
          <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select Content Type"
            aria-hidden="true" id="category" name="category" required>
            <option label="Select Category" disabled selected>Select Category</option>
            @foreach($categories as $item)
            <option value="{{ $item->name }}">{{ $item->label}}</option>
            @endforeach
          </select>
          <a href="/admin/category/create" rel="noopener noreferrer">Add new category</a>
        </div>
      </div>
      <!-- col-4 -->
      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">Access Level:
            <span class="tx-danger">*</span></label>
          <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select access type"
            aria-hidden="true" id="content_access" name="content_access" required>
            <option label="Select access type" disabled selected>-- Select access type --</option>
            <option value="free">free</option>
            <option value="premium">Premium</option>
          </select>
        </div>
      </div>
      <!-- col-4 -->

      <!-- col-4 -->
      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">What will you tag this content:
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
      </div>
      <!-- col-4 -->

    </div>
    <!-- row -->
</div>
</div>
<!-- card -->

<div class="card pd-20 pd-sm-40 mg-t-10">
  <div class="form-layout center-block">
    <div class="row mg-b-25">
      <!-- col-4 -->


      <div class="col-lg-6">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">Title: <span class="tx-danger">*</span></label>
          <input class="form-control select2 select2-hidden-accessible" type="text" name="title" id="title" name="title"
            placeholder="My content title" required />
        </div>
      </div>
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
          <a href="/admin/subject/create" rel="noopener noreferrer">Add new subject</a>
        </div>
      </div>
    </div>
  </div>

  <br />

  <div id="editor_box">
    <div class="col-lg-12 form-layout">
      <div class="form-group mg-b-10-force">
        <!-- col-12 -->
        <label class="form-control-label">
          Body text content
        </label>

        <!-- The toolbar will be rendered in this container. -->
        <div id="toolbar-container"></div>

        <!-- This container will become the editable. -->
        <div id="editor" style="height: 300px; border: 1px solid rgba(68, 68, 68, 0.26);"></div>
        <textarea rows="3" class="hidden form-control select2 select2-hidden-accessible" name="body" id="body"
          style="height: 300px; width: 100%; border: 1px solid rgba(68, 68, 68, 0.26);"
          placeholder="This is the initial editor content."></textarea>
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
      <div id="media_box" class="row col-lg-12">
        <div class="col-lg-6">
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
        <div class="col-lg-6">
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
        <!-- col-4 -->
        <div class="col-lg-6">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Video Thumbnail:</label>
            <!-- <label class="custom-file"> -->
            <input type="file" accept="image/*" id="thumbnail" name="thumbnail"
              class="form-control select2 select2-hidden-accessible" />
            <!-- <span class="custom-file-control"></span> -->
            <!-- </label> -->
          </div>
        </div>
        <!-- col-4 -->
        <!-- col-4 -->

        <div class="col-lg-6">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Publish Status: <span class="tx-danger">*</span></label>
            <label class="ckbox">
              <input type="checkbox" checked id="publish" name="publish" />
              <span>Publish Content</span>
            </label>
          </div>
        </div>
        <!-- col-4 -->
      </div>


    </div>
    <!-- row -->

    <div class="form-layout-footer">
      <button class="btn btn-primary mg-r-5" type="submit" id="submit-btn">
        Submit Form
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

{{-- <script src="{{ asset('lib/jquery/jquery.js') }}"></script> --}}
{{-- <script src="{{ asset('lib/popper.js/popper.js') }}"></script>
<script src="{{ asset('lib/bootstrap/bootstrap.js') }}"></script> --}}
{{-- <script src="{{ asset('lib/jquery-ui/jquery-ui.js') }}"></script> --}}
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