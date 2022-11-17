@extends('layouts.default') 

@section('title')
Edit Tag
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
    <form id="tag-form" action="{{ route('update-tag') }}" method="PUT">
        @csrf
        
        <div class="card pd-20 pd-sm-40">
            <p class="mg-b-20 mg-sm-b-30">
                <span style="color:red;">*</span> Marked fields are required.
            </p>
            <div class="form-layout">
                <div class="row mg-b-25">
                    <div class="col-12">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Tag Name:
                                <span class="tx-danger">*</span></label>
                            <input value="{{ $tag->id }}" id="id" name="id" required type="hidden">
                            <input value="{{ $tag->label }}" class="form-control " data-placeholder="Title" aria-hidden="true" id="label" name="label" required type="text" name="">

                        </div>
                    </div>
                    <!-- col-4 -->
                    <div class="col-lg-12 mg-t-20">
                        <div class="form-group mg-b-10-force mgt-t-20">
                            <button class="btn btn-primary mg-r-5" type="submit" id="submit-btn">
                                Save
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
