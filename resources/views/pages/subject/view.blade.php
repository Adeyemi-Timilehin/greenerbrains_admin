@extends('layouts.default') 

@section('title')
View Subject
@endsection

@section('content')
<div class="kt-pagetitle">
  <h5>View Subject</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
  @if(Session::has('error'))
  <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{!! Session::get('error') !!}</p>
  @endif

  @if(Session::has('success'))
  <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
  @endif
  
  @csrf @if(isset($success))
  <script>
    Swal.fire({
      position: "top-end",
      icon: "success",
      title: "successful",
      showConfirmButton: false,
      timer: 1500,
    });
  </script>
  @endif
  <div class="card pd-20 pd-sm-40">
    <div class="form-layout">
      <div class="row mg-b-25">
        @if (isset($subject->preview_video ))
        <div class="col-12">
          <div class="form-group mg-b-10-force border bordered">
            <iframe src="{{ $subject->preview_video }}" frameborder="0" style="width:100%; height: 265px;"
              poster="{{ $subject->thumbnail }}"
              allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            {{-- <video controls src="{{ $subject->preview_video }}" poster="{{ $subject->thumbnail }}" width="100%">

              Sorry, your browser doesn't support embedded videos,
              but don't worry, you can <a href="https://archive.org/details/BigBuckBunny_124">download it</a>
              and watch it with your favorite video player!</video> --}}
          </div>
        </div>
        @endif
        <div class="col-12">
        <hr>
        <h2>Properties</h2>
        <br>
        <table class="table border table-border">
          <tbody>
            <tr>
              <td><img class="img-thumbnail" width="80px" src="{{ $subject->thumbnail ? $subject->thumbnail : '' }}"
                  alt=""></td>
            </tr>
            <tr>
              <td scope="row">Title</td>
              <td>{{ $subject->label }}</td>
            </tr>
            <tr>
              <td scope="row">Category</td>
              <td>{{ $subject->Category ? $subject->Category->label : "" }}</td>
            </tr>
            <tr>
              <td scope="row">Price</td>
              <td>{{ $subject->price ? $subject->price : 0 }}</td>
            </tr>
            <tr>
              <td scope="row">Access</td>
              <td>{{ $subject->access ? $subject->access : 'Not set' }}</td>
            </tr>
            <tr>
              <td scope="row">Rating</td>
              <td>{{ $subject->rating }}</td>
            </tr>
            <tr>
              <td scope="row">Tags</td>
              <td>
                @for ($j = 0; $j < count($subject->tags); $j++)
                  <span class="badge badge-primary square">{{ $subject->tags[$j]->label }}</span>
                  @endfor
              </td>
            </tr>
            @if (isset($subject->description) && $subject->description !== '')
            <tr>
              <td></td>
              <td>
                <h4>Description</h4>
                {{ $subject->description }}
              </td>
            </tr>
            @endif
            @if (isset($subject->summary) && $subject->summary !== '')
            <tr>
              <td></td>
              <td>
                <h4>Summary</h4>
                {{ $subject->summary }}
              </td>
            </tr>
            @endif
          </tbody>
        </table>
        </div>


        <!-- <div class="col-12"> -->
        <!-- <hr class="p-2"/> -->
        @if (!count($subject->Contents)) 

        <div class="col-12">
          <hr class="hr-primary">
          <h2>Contents</h2>
          <p>No Content added to this subject</p>
          <a href="{{ route('add-content') }}" type="button" class="btn btn-primary">Add New Content</a>
        </div>
        @else
        <div class="col-12">
        <hr class="hr-primary">
        <h2 class="">Contents</h2>
        <table class="table border table-border mg-b-0">
          <thead>
            <tr>
              <th>Title</th>
              <th>Category</th>
              <th>Type</th>
              <th class="hidden-xs-down">Modified</th>
              <th class="wd-5p"></th>
            </tr>
          </thead>
          <tbody id="content_list">
            @foreach ($subject->Contents as $key => $content)
            <tr class="content-item">
              <a href="{{ route('show-content', ['id' => $content->id]) }}">
                <td><a href="{{ route('show-content', ['id' => $content->id]) }}">{{ $content->title ? $content->title : '' }}</a>
                </td>
                <td>{{ $content->contentCategory ? $content->contentCategory['label'] : '' }}</td>
                <td>{{ $content->contentType ? $content->contentType['label'] : '' }}</td>
                <td>{{ $content->created_at ? $content->created_at : '' }}</td>
                <td></td>
              </a>
            </tr>
            @endforeach
          </tbody>
        </table>
        <hr class="hr-primary">
        </div>
        @endif


      <hr class="p-2" />
      <!-- </div> -->
      <!-- col-4 -->

      <div class="col-lg-12 mg-t-0">
        <div class="form-group mg-b-0-force">
          <a href="{{ route('edit-subject', ['id' => $subject->id ]) }}" class="btn btn-info mg-r-5">Edit Subject</a>
          <!-- <button class="btn btn-default mg-r-5"  id="submit-btn">
              Back
            </button> -->
        </div>
      </div>
    </div>
    <!-- row -->
  </div>
</div>
<!-- card -->
</div>

@stop