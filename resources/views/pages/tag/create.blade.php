@extends('layouts.default') 

@section('title')
Add New Tag
@endsection

@section('content')
<div class="kt-pagetitle">
    <h5>New Tag</h5>
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
      <a type="button" href="{{ route('tag') }}" class="btn btn-secondary pd-x-25 active">
          All Tags  <i class="fa fa-list" aria-hidden="true"></i>
      </a>
  </div>

    <form id="tag-form" action="{{ route('new-tag') }}" method="POST">
        @csrf

        <div class="card pd-20 pd-sm-40">
            <p class="mg-b-20 mg-sm-b-30">
                <span style="color:red;">*</span> Marked fields are required.
            </p>
            <div class="form-layout">
                <div class="row mg-b-25">
                    <div class="col-lg-6">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Tag Name:
                                <span class="tx-danger">*</span></label>
                            <input class="form-control" data-placeholder="Title" aria-hidden="true" id="label" name="label" required type="text" name=""/>
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

@stop
