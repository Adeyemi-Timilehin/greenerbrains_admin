@extends('layouts.default') 

@section('title')
Add Post
@endsection

@section('content')
<div class="kt-pagetitle">
<h5>@yield('title')</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
  @if(Session::has('error'))
  <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{!! Session::get('error') !!}</p>
  @endif

  @if(Session::has('success'))
  <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
  @endif

  <form id="post-form" enctype="multipart/form-data" action="{{ route('post.store') }}" method="POST">
    @csrf 
    
    @if(isset($success))
    <input type="hidden" name="user_id" value="Auth::user()->id">
    @endif

    <div class="card pd-20 pd-sm-40 mg-b-25">
      <p class="mg-b-20 mg-sm-b-30">
        <span style="color: red;">*</span> Marked fields are required.
      </p>
      <div class="form-layout">
        <div class="row mg-b-25">
          <div class="col-12">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Title:
                <span class="tx-danger">*</span></label>
              <input class="form-control" data-placeholder="Title" aria-hidden="true" id="title" name="title" required
                type="text" />
            </div>
          </div>
        </div>
      </div>
    {{-- </div>
        

    <div class="card pd-20 pd-sm-40 mg-b-25"> --}}
    <div id="editor_box">
      <div class="col-lg-12 form-layout">
        <div class="form-group mg-b-10-force">
          <!-- col-12 -->
          <label class="form-control-label">
            Post Content
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


    <div class="card pd-20 pd-sm-40">
      <div class="form-layout">
        <div class="row mg-b-25">
          <!-- col-4 -->
          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Post Image:
                <span class="tx-danger">*</span></label>
              <input class="form-control" data-placeholder="Upload thumbail image" aria-hidden="true" id="thumbnail"
                name="image" accept="image/*" required type="file" />
            </div>
          </div>
          
          

          @if (isset($tags))
            <div class="col-lg-6">
            <br />
            <p class="mg-b-10">
              What will you tag this post?
              <span class="tx-danger">*</span>
            </p>
            <div id="cbWrapper" class="parsley-checkbox">
              @foreach($tags as $item)
              <label class="ckbox" style="display: inline-block;">
                <input type="checkbox" value="{{ $item->id }}" id="tags" name="tags[]"
                  data-parsley-multiple="browser" /><span>{{ $item->label }}</span>
              </label>
              @endforeach
            </div>
            <a href="{{ route('add-tag') }}" rel="noopener noreferrer">Add new tags</a>
          </div> 
          @endif



          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Publish Date:
              </label>
              <input type="date" class="form-control" placeholder="MM/DD/YYYY" id="publish_date"
                name="publish_date" />
            </div>
          </div>
          <!-- col-4 -->
          

          <div class="col-lg-12 mg-t-20">
            <hr class="pd-20">
            <div class="form-group mg-b-10-force mgt-t-20">
              <button class="btn btn-primary mg-r-5" type="submit" id="submit-btn">
                Submit
              </button>
              <button class="btn btn-danger" type="reset">
                Cancel
              </button>
            </div>
          </div>
        </div>
        <!-- row -->
      </div>

    </div>
    <!-- card -->
  </form>
</div>
<!-- <script src="{{ asset('lib/medium-editor/medium-editor.js') }}"></script> -->
<script>
  document.addEventListener("DOMContentLoaded", event => {
    let title_field = document.getElementById("title");
    let editor = document.getElementById("editor");
    let body = document.getElementById("body");
    let submit_btn = document.getElementById("submit-btn");
    let content_form = document.getElementById("post-form");

    editor.addEventListener("keydown", e => {
      body.value = editor.innerHTML;
    });

    content_form.addEventListener("submit", e => {
      body.value = editor.innerHTML;
    });

  });
</script>
@stop