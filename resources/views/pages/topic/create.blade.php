@extends('layouts.default') @section('content')
<div class="kt-pagetitle">
    <h5>New Topic</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
    <form id="topic-form" action="{{ route('new-topic') }}" method="POST">
        @csrf
        @if(isset($success))
        <h1>Success</h1>
        <script>
            Swal.fire({
                position: "top-end"
                , icon: "success"
                , title: "Your content has been saved"
                , showConfirmButton: false
                , timer: 1500
            });

        </script>
        @endif
        <div class="card pd-20 pd-sm-40">
            <p class="mg-b-20 mg-sm-b-30">
                <span style="color:red;">*</span> Marked fields are required.
            </p>
            <div class="form-layout">
                <div class="row mg-b-25">
                    <div class="col-12">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Topic Title:
                                <span class="tx-danger">*</span></label>
                            <input class="form-control " data-placeholder="Title" aria-hidden="true" id="label" name="label" required type="text" name="">

                        </div>
                    </div>
                    <!-- col-4 -->

                    <div class="col-lg-4">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Category:
                                <span class="tx-danger">*</span></label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select Content Type" aria-hidden="true" id="category" name="category" required>
                                <option label="Select Category" disabled selected>Select Category</option>
                                @foreach($categories as $item)
                                <option value="{{ $item->name }}">{{ $item->label}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- col-4 -->
                    <div class="col-lg-4">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Sub-Category:
                                <span class="tx-danger">*</span></label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select Sub-Category" aria-hidden="true" id="sub_category" name="sub_category" required>
                                <option label="Select Category" disabled selected>Select Sub-Category</option>
                                @foreach($sub_categories as $item)
                                <option value="{{ $item->name }}">{{ $item->label}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- col-4 -->
                    <div class="col-lg-4">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Access Type:
                                <span class="tx-danger">*</span></label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select access type" aria-hidden="true" id="content_access" name="content_access" required>
                                <option label="Select access type" disabled selected>Select access type</option>
                                @foreach($accesses as $item)
                                <option value="{{ $item->name }}">{{ $item->label}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- col-4 -->
                </div>
                <!-- row -->
            </div>
        </div>
        <!-- card -->


        <div class="card pd-20 pd-sm-40 mg-t-10">
            <div class="form-layout">


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
<!-- <script src="{{ asset('lib/medium-editor/medium-editor.js') }}"></script> -->
<script src="{{ asset('js/axios.min.js') }}"></script>

@stop
