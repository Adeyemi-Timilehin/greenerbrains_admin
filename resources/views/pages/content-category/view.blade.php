@extends('layouts.default') 

@section('title')
View Category
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
    @if (isset($category))
    <div class="form-layout">
      <div class="row mg-b-25">
        <div class="mb-4">
          <h1>
            {{ $category->label ? $category->label .' category' : '' }}
          </h1>
          <br>
          <p>
            {!! $category->description ? $category->description : "<strong>$category->label</strong> is a basic category for grouping courses and contents." !!}
          </p>
        </div>


        <div class="col-12">
        <hr class="p-2"/>
        @if (isset($category->subjects) && !count($category->subjects)) 
        <div class="mb-4">
          <h2>Subjects</h2>
          <p>No Subject in this category</p>
          <a href="{{ route('add-subject') }}" type="button" class="btn btn-primary">Add Subject</a>
        </div>
        @else
          <h4>Courses</h4>
          <table class="table table-striped mg-b-0 mg-t-20">
            <thead>
                <tr>
                    <th>Course Title</th>
                    <th class="hidden-xs-down">Price</th>
                    <th class="hidden-xs-down">Content Count</th>
                    <th class="hidden-xs-down">Last Updated</th>
                    <th class="wd-5p"></th>
                </tr>
            </thead>
            <tbody id="cat-tb-bdy">
                @foreach($category->subjects as $item)


                <tr id="{{$item->name}}-category">
                    <a href="{{ route('show-subject', ['id' => $item->id]) }}">
                    <td>
                        <a href="{{ route('show-subject', ['id' => $item->id]) }}">
                            <i class="fa fa-file-o tx-22 tx-danger lh-0 valign-middle"></i>
                            <span class="pd-l-5">{{ $item->label }}</span>
                        </a>
                    </td>
                    </a>
                    <td class="hidden-xs-down"><a href="{{ route('show-subject', ['id' => $item->id]) }}">{{ $item->price }}</a></td>
                    <td class="hidden-xs-down"><a href="{{ route('show-subject', ['id' => $item->id]) }}">{{ $item->contents ? count($item->contents) : 0 }}</a></td>
                    <td class="hidden-xs-down"><a href="{{ route('show-subject', ['id' => $item->id]) }}">{{ $item->updated_at ? $item->updated_at->diffForHumans() : 'Not defined' }}</a></td>

                    <td class="dropdown">
                        <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i
                                class="icon ion-more"></i></a>
                        <div class="dropdown-menu dropdown-menu-right pd-10">
                            <nav class="nav nav-style-1 flex-column">

                                <a href="{{ route('edit-subject', ['id' => $item->id]) }}" class="nav-link">Edit</a>

                                <a href="{{ route('delete-subject', ['id' => $item->id]) }}" class="nav-link danger">Delete</a>

                            </nav>
                        </div>
                        <!-- dropdown-menu -->
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
      </div>


        <div class="col-12">
        <hr class="p-2"/>
        @if (isset($category->contents) && !count($category->contents)) 
        <div class="mb-4">
          <h2>Contents</h2>
          <p>No Content in this Category</p>
          <a href="{{ route('add-content') }}" type="button" class="btn btn-primary">Add Contents</a>
        </div>
        @else
          <h4>Contents</h4>
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
              @foreach ($category->contents as $key => $content)
              <tr class="content-item">
                <a href="{{ route('show-content', ['id' => $content->id ]) }}">
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
        @endif
        </div>


      <hr class="p-2" />
      <!-- </div> -->
      <!-- col-4 -->

      <div class="col-lg-12 mg-t-0">
        <div class="form-group mg-b-0-force">
          <a href="{{ route('show-category', ['id' => $category->id]) }}" class="btn btn-info mg-r-5">Edit Category</a>
          <!-- <button class="btn btn-default mg-r-5"  id="submit-btn">
              Back
            </button> -->
        </div>
      </div>
    </div>
    @endif
    <!-- row -->
  </div>
</div>
<!-- card -->
</div>
<!-- <script src="{{ asset('lib/medium-editor/medium-editor.js') }}"></script> -->
<script src="{{ asset('js/axios.min.js') }}"></script>

@stop