@extends('layouts.default') 

@section('title')
Add New Subject
@endsection

@section('content')
<div class="kt-pagetitle">
  <h5>New Subject</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
  @if(Session::has('error'))
  <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{!! Session::get('error') !!}</p>
  @endif

  @if(Session::has('success'))
  <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
  @endif

  <form id="subject-form" enctype="multipart/form-data" action="{{ route('new-subject') }}" method="POST">
    @csrf @if(isset($success))
    <input type="hidden" name="publisher_id" value="Auth::user()->id">
    <script>
      document.addEventListener("DOMContentLoaded", (event) => {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Your subject has been saved",
          showConfirmButton: false,
          timer: 2500,
        });
      });
    </script>
    @endif @if(isset($error))
    <script>
      document.addEventListener("DOMContentLoaded", (event) => {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "{{$error}}",
          showConfirmButton: false,
          timer: 2500,
        });
      });
    </script>
    @endif
    <div class="card pd-20 pd-sm-40">
      <p class="mg-b-20 mg-sm-b-30">
        <span style="color: red;">*</span> Marked fields are required.
      </p>
      <div class="form-layout">
        <div class="row mg-b-25">
          <div class="col-8">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Subject Title:
                <span class="tx-danger">*</span></label>
              <input class="form-control" data-placeholder="Title" aria-hidden="true" id="label" name="label" required
                type="text" />
            </div>
          </div>
          <div class="col-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Price:</label>
              <input class="form-control" min="0" data-placeholder="Price" aria-hidden="true" step=".01" id="price" name="price" required
                type="number" />
                <span class="tx-danger">defaults to null if access type is 'free'</span>
            </div>
          </div>
          <!-- col-4 -->
          <div class="col-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Thumbnail:
                <span class="tx-danger">*</span></label>
              <input class="form-control" data-placeholder="Upload thumbail image" aria-hidden="true" id="thumbnail"
                name="thumbnail" accept="image/*" required type="file" />
            </div>
          </div>
          <!-- col-4 -->
          <div class="col-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Short Video:
                <span class="tx-danger">(Not compulsory)</span></label>
              <input class="form-control" data-placeholder="Upload preview video" aria-hidden="true" id="preview_video"
                accept="video/*" name="preview_video" type="file" />
            </div>
          </div>
          <!-- col-4 -->
          <div class="col-12">
            <div class="form-group mg-b-10-force">
              <label for="description">Description<span class="tx-danger">*</span></label>
              <textarea id="description" name="description" class="form-control" rows="3"></textarea>
            </div>
          </div>

          <!-- col-4 -->
          <div class="col-12">
            <div class="form-group mg-b-10-force">
              <label for="summary">Summary</label>
              <textarea id="summary" name="summary" class="form-control" rows="8"></textarea>
            </div>
          </div>
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
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Access Type:
                <span class="tx-danger">*</span></label>
              <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select access type"
                aria-hidden="true" id="access" name="access" required>
                <option label="Select access type" disabled selected>-- Select access type --</option>
                <option value="free">free</option>
                <option value="premium">Premium</option>
              </select>
            </div>
          </div>
          <!-- col-4 -->
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Rating: <span class="tx-danger">*</span></label>
              <input type="number" max="5" min="0" class="form-control select2-hidden-accessible" aria-hidden="true"
                id="rating" name="rating" required />
            </div>
          </div>
          <!-- col-4 -->

          <div class="col-6">
            <br />
            <p class="mg-b-10">
              What will you tag this subject?
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
            <a href="/admin/tag/create" rel="noopener noreferrer">Add new tags</a>
            <hr />
          </div>

          <!-- col-4 -->
          <div class="col-6">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Language:
                <span class="tx-danger">Default Language: English!</span></label>
              <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select access type"
                aria-hidden="true" id="language" name="language" data-placeholder="Choose a Language...">
                <option value="Afrikaans">Afrikaans</option>
                <option value="Albanian">Albanian</option>
                <option value="Arabic">Arabic</option>
                <option value="Armenian">Armenian</option>
                <option value="Basque">Basque</option>
                <option value="Bengali">Bengali</option>
                <option value="Bulgarian">Bulgarian</option>
                <option value="Catalan">Catalan</option>
                <option value="Cambodian">Cambodian</option>
                <option value="Chinese (Mandarin)">Chinese (Mandarin)</option>
                <option value="Croatian">Croatian</option>
                <option value="Czech">Czech</option>
                <option value="Danish">Danish</option>
                <option value="Dutch">Dutch</option>
                <option value="English" selected>English</option>
                <option value="Estonian">Estonian</option>
                <option value="Fiji">Fiji</option>
                <option value="Finnish">Finnish</option>
                <option value="French">French</option>
                <option value="Georgian">Georgian</option>
                <option value="German">German</option>
                <option value="Greek">Greek</option>
                <option value="Gujarati">Gujarati</option>
                <option value="Hebrew">Hebrew</option>
                <option value="Hindi">Hindi</option>
                <option value="Hungarian">Hungarian</option>
                <option value="Icelandic">Icelandic</option>
                <option value="Indonesian">Indonesian</option>
                <option value="Irish">Irish</option>
                <option value="Italian">Italian</option>
                <option value="Japanese">Japanese</option>
                <option value="Javanese">Javanese</option>
                <option value="Korean">Korean</option>
                <option value="Latin">Latin</option>
                <option value="Latvian">Latvian</option>
                <option value="Lithuanian">Lithuanian</option>
                <option value="Macedonian">Macedonian</option>
                <option value="Malay">Malay</option>
                <option value="Malayalam">Malayalam</option>
                <option value="Maltese">Maltese</option>
                <option value="Maori">Maori</option>
                <option value="Marathi">Marathi</option>
                <option value="Mongolian">Mongolian</option>
                <option value="Nepali">Nepali</option>
                <option value="Norwegian">Norwegian</option>
                <option value="Persian">Persian</option>
                <option value="Polish">Polish</option>
                <option value="Portuguese">Portuguese</option>
                <option value="Punjabi">Punjabi</option>
                <option value="Quechua">Quechua</option>
                <option value="Romanian">Romanian</option>
                <option value="Russian">Russian</option>
                <option value="Samoan">Samoan</option>
                <option value="Serbian">Serbian</option>
                <option value="Slovak">Slovak</option>
                <option value="Slovenian">Slovenian</option>
                <option value="Spanish">Spanish</option>
                <option value="Swahili">Swahili</option>
                <option value="Swedish ">Swedish </option>
                <option value="Tamil">Tamil</option>
                <option value="Tatar">Tatar</option>
                <option value="Telugu">Telugu</option>
                <option value="Thai">Thai</option>
                <option value="Tibetan">Tibetan</option>
                <option value="Tonga">Tonga</option>
                <option value="Turkish">Turkish</option>
                <option value="Ukrainian">Ukrainian</option>
                <option value="Urdu">Urdu</option>
                <option value="Uzbek">Uzbek</option>
                <option value="Vietnamese">Vietnamese</option>
                <option value="Welsh">Welsh</option>
                <option value="Xhosa">Xhosa</option>
              </select>
            </div>
          </div>

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