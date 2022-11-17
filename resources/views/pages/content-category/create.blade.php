@extends('layouts.default') 


@section('title')
Add Category
@endsection


@section('content')
<div class="kt-pagetitle">
  <h5>New Category</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
  @if(Session::has('error'))
  <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{!! Session::get('error') !!}</p>
  @endif

  @if(Session::has('success'))
  <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
  @endif

  <div class="btn-group mg-b-20" role="group" aria-label="Basic example">
    <a type="button" href="{{ route('category') }}" class="btn btn-secondary pd-x-25 active">
      Category List <i class="fa fa-list-alt" aria-hidden="true"></i>
    </a>
  </div>
  <form id="category-form" enctype="multipart/form-data" action="{{ route('new-category') }}" method="POST">
    @csrf

    <div class="card pd-20 pd-sm-40">
      <p class="mg-b-20 mg-sm-b-30">
        <span style="color:red;">*</span> Marked fields are required.
      </p>
      <div class="form-layout">
        <div class="row mg-b-25">

          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Name:
                <span class="tx-danger">*</span></label>
              <input class="form-control " data-placeholder="Title" aria-hidden="true" id="label" name="label" required
                type="text" />
            </div>
          </div>
          <!-- col-4 -->

          <div class="col-lg-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Thumbnail image:</label>
              <input class="form-control" accept="image/*" data-placeholder="Title" aria-hidden="image" id="image" name="image" required
                type="file" />
            </div>
          </div>
          <!-- col-4 -->

          <div class="col-12">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Description:
                <span class="tx-danger">*</span></label>
              <textarea name="description" required class="form-control " id="description" rows="5"></textarea>
            </div>
          </div>
          <!-- col-4 -->

          <div class="col-lg-12 mg-t-20">
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
<script src="{{ asset('js/axios.min.js') }}"></script>

@stop