@extends('layouts.default')

@section('title')
All Contents
@endsection

@section('content')
<div class="kt-pagetitle">
  <h5>Content Manager</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
  <div class="content-wrapper">
    @if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    {{-- <div class="alert alert-primary" role="alert">
        {{ isset($message) ? $message : '' }}
  </div> --}}
  @endif

  @if(Session::has('error'))
  <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{!! Session::get('error') !!}</p>
  @endif

  @if(Session::has('success'))
  <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
  @endif

  
  <a type="button" href="{{ route('add-content') }}" class="btn btn-secondary pd-x-25 active mb-2">
    Add New <i class="fa fa-plus" aria-hidden="true"></i>
  </a>

  <div class="content-body" style="margin-left: 0px;">
    <div class="content-body-header">

      <div class="mg-l-auto">
        {{ $contents->links() }}
        <!-- btn-group -->
      </div>
    </div>
    <div class="table-responsive">
      <table class="table mg-b-20">
        <thead>
          <tr>
            <th></th>
            <th>Title</th>
            <th>Category</th>
            <th>Type</th>
            <th>Status</th>
            <th class="hidden-xs-down">Last Update</th>
            <th class="wd-5p"></th>
          </tr>
        </thead>
        <tbody id="content_list">
          @foreach ($contents as $key => $content)
          <tr class="content-item">
            <td>
              @if ($content->media)
              <a class="pull-left" href="#">
                <img class="media-object" style="width: 40px; height:40px;"
                  src="{{ $content->media ? $content->media->thumbnail : null }}">
              </a>
              @endif
            </td>
            <td><a href="{{ route('show-content', $content) }}">{{ $content->title ? $content->title : '' }}</a></td>
            <td>{{ $content->contentCategory ? $content->contentCategory['label'] : '' }}</td>
            <td>{{ $content->contentType ? $content->contentType['label'] : '' }}</td>
            <td>
              @if ($content->is_published)
              <span class="badge badge-pill badge-success p-2">published</span>

              @else
              <span class="badge badge-pill badge-danger p-2">unpublished</span>
              @endif
            </td>
            <td>{{ $content->updated_at ? $content->updated_at : '' }}</td>
            <td class="dropdown">
              <a href="#" data-toggle="dropdown" class="btn btn-primary hover-info"><i
                  class="icon ion-more text-white white"></i></a>
              <div class="dropdown-menu dropdown-menu-right pd-10">
                <nav class="nav nav-style-1 flex-column">

                  <a href="/admin/content/{{ $content->id }}/edit" class="nav-link">Edit</a>

                  <a href="{{ route('delete-content', ['id' => $content->id]) }}" class="nav-link danger">Delete</a>
                  @if ($content->is_published == true)
                  <a href="{{ route('unpublish-content', ['id' => $content->id ]) }}"
                    class="nav-link warning">Unpublish</a>
                  @else
                  <a href="{{ route('publish-content', ['id' => $content->id ]) }}" class="nav-link danger">Publish</a>
                  @endif
                </nav>
              </div>
              <!-- dropdown-menu -->
            </td>
          </tr>
          @endforeach
          @if(count($contents) < 1) <tr style="text-align: center">
            <td>
              <div>
                <p>No Content added to this subject</p>
                <a href="/admin/content/create" type="button" class="btn btn-primary">Add New Content</a>
              </div>
            </td>
            </tr>
            @endif
        </tbody>
      </table>
    </div>
    <div class="content-body-header">
      <div class="mg-l-auto">
        {{ $contents->links() }}
      </div>
    </div>
  </div>
</div>
</div>
<!-- kt-pagebody -->
<script src="{{ asset('js/axios.min.js') }}"></script>

<style>
  .content-item:hover,
  .content-item td:hover {
    background-color: #6cc091;
    color: white !important;
  }

  a {
    text-transform: none;
    text-decoration: none;
    cursor: pointer;
  }

  table {
    margin-bottom: 200px;
  }
</style>
@stop