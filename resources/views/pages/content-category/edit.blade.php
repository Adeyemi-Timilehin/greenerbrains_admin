@extends('layouts.default') 

@section('title')
Edit Category
@endsection

@section('content')
<div class="kt-pagetitle">
    <h5>New Category</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
    <form id="category-form" action="{{ route('edit-category-form') }}" method="PUT">
        @csrf
        @if(isset($success))
        <script>
            document.addEventListener("DOMContentLoaded", event => {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Your category has been saved",
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        </script>
        @endif
        @if(isset($error))
        <script>
            document.addEventListener("DOMContentLoaded", event => {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "{{$error}}",
                    showConfirmButton: false,
                    timer: 2500
                });
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
                            <label class="form-control-label"
                                >Category Name:
                                <span class="tx-danger">*</span></label
                            >
                            <input value="{{ $category->id }}" id="id" name="id" required type="hidden">
                            <input
                                class="form-control "
                                data-placeholder="Title"
                                aria-hidden="true"
                                id="label"
                                name="label"
                                required
                                type="text"
                                value="{{ $category ? $category->label : '' }}"
                            />
                        </div>
                    </div>
                    <!-- col-4 -->

                    <div class="col-12">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label"
                                >Description:
                                <span class="tx-danger">*</span></label
                            >
                            <textarea name="description" class="form-control " id="description" rows="5">{{ $category->description ? $category->description : '' }}</textarea>
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
