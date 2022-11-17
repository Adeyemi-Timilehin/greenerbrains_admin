@extends('layouts.default') 

@section('title')
Edit Subject
@endsection

@section('content')
<div class="kt-pagetitle">
  <h5>Edit Subject</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
  @if(Session::has('error'))
  <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{!! Session::get('error') !!}</p>
  @endif

  @if(Session::has('success'))
  <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
  @endif

  <form id="subject-form" action="{{ route('update-subject', [ 'id' => $subject->id, 'subject' => $subject ]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card pd-20 pd-sm-40">
      <p class="mg-b-20 mg-sm-b-30">
        <span style="color:red;">*</span> Marked fields are required.
      </p>
      <div class="form-layout">
        <div class="row mg-b-25">
          <div class="col-12 col-md-8 col-sm-8">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Subject Title:
                <span class="tx-danger">*</span></label>
              <input value="{{ $subject->id }}" id="id" name="id" required type="hidden">
              <input value="{{ $subject->label }}" class="form-control " data-placeholder="Title" aria-hidden="true"
                id="label" name="label" required type="text" name="">
            </div>
          </div>
          <div class="col-12 col-md-4 col-sm-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Price:</label>
              <input class="form-control" value="{{ $subject->price }}" min="0" step=".01" data-placeholder="Price" aria-hidden="true" id="price" name="price"
                type="number" />
                <span class="tx-danger">defaults to null if access type is 'free'</span>
            </div>
          </div>
          <!-- col-4 -->
        </div>
      </div>
    </div>

    <div class="card pd-20 pd-sm-40 mt-4">
      <div class="form-layout">
        <div class="row mg-b-25">

          <!-- col-4 -->
          @if (isset($subject->thumbnail ))
          <div class="col-12 col-md-6 col-sm-6">
            <div class="form-group mg-b-10-force border bordered">
              <img src="{{ $subject->thumbnail }}" title="Subject image thumbnail" style="width:100%; height: 265px;">
            </div>
          </div>
          @endif

          @if (isset($subject->preview_video ))
          <div class="col-12 col-md-6 col-sm-6">
            <div class="form-group mg-b-10-force border bordered">
              <iframe src="{{ $subject->preview_video }}" title="Subject preview video" frameborder="0" style="width:100%; height: 265px;"
                poster="{{ $subject->thumbnail }}"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
          @endif

          <!-- col-4 -->
          <div class="col-12 col-md-6 col-sm-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Thumbnail:
                <span class="tx-danger">*</span></label>
                <input class="form-control" title="Upload subject thumbnail photo" name="thumbnail" accept="image/*" type="file" />
            </div>
          </div>
          <!-- col-4 -->
          <div class="col-12 col-md-6 col-sm-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Preview Video:
                <span class="tx-danger">(Not compulsory)</span></label>
                <input class="form-control" title="Upload subject preview video" id="preview_video" accept="video/*" name="preview_video" type="file" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card pd-20 pd-sm-40 mt-4">
      <div class="form-layout">
        <div class="row mg-b-25">
          <!-- col-4 -->
          <div class="col-12">
            <div class="form-group mg-b-10-force">
              <label for="description">Description<span class="tx-danger">*</span></label>
              <textarea id="description" name="description" class="form-control"
                rows="3">{{ $subject->description }}</textarea>
            </div>
          </div>

          <!-- col-4 -->
          <div class="col-12">
            <div class="form-group mg-b-10-force">
              <label for="summary">Summary</label>
              <textarea id="summary" name="summary" class="form-control" rows="8">{{ $subject->summary }}</textarea>
            </div>
          </div>
          <!-- col-4 -->

          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Category:
                <span class="tx-danger">*</span></label>
              <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select Content Type"
                aria-hidden="true" id="category" name="category" required>
                <option label="Select Category" disabled>Select Category</option>
                @foreach($categories as $item)
                <option value="{{ $item->name }}" {{ $subject->category == $item->id || $subject->category == $item->name ? 'selected' : '' }}>
                  {{ $item->label}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- col-4 -->
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Access Type:
                <span class="tx-danger">*</span></label>
              <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select access type"
                aria-hidden="true" id="access" name="access" required>
                <option label="Select access type" disabled selected>-- Select access type --</option>
                <option value="free" {{ $subject->access == 'free' ? 'selected' : '' }}>free</option>
                <option value="premium" {{ $subject->access == 'premium' ? 'selected' : '' }}>Premium</option>
              </select>
            </div>
          </div>
          <!-- col-4 -->
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Rating: <span class="tx-danger">*</span></label>
              <input type="number" max="5" min="0" class="form-control select2-hidden-accessible" aria-hidden="true"
                id="rating" name="rating" required value="{{ $subject->rating }}" />
            </div>
          </div>


          <div class="col-12">
            <br>
            <div id="cbWrapper" class="parsley-checkbox">
              @foreach($tags as $item)
              @for ($j = 0; $j < count($subject->tags); $j++)
                @if ($item->id == $subject->tags[$j]['id'])
                <label class="ckbox" style="display:inline-block;">
                  <input type="checkbox" value="{{ $item->id }}" disabled data-parsley-multiple="browser"
                    checked><span>{{ $item->label }}</span>
                </label>
                @endif
                @endfor
                @endforeach
                <br>
                <hr>
                <p class="mg-b-10">Edit Subject tags</p>
                @foreach($tags as $item)
                <label class="ckbox" style="display:inline-block;">
                  <input type="checkbox" value="{{ $item->id }}" id="tags" name="tags[]"
                    data-parsley-multiple="browser"><span>{{ $item->label }}</span>
                </label>
                @endforeach
            </div>
            <hr>
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
{{-- <!-- <script src="{{ asset('lib/medium-editor/medium-editor.js') }}"></script> --> --}}
{{-- <script src="{{ asset('js/axios.min.js') }}"></script> --}}

@stop