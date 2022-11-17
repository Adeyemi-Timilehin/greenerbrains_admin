@extends('layouts.default')

@section('title')
Category List
@endsection

@section('content')
<style>
  .content-body {
    margin: 0px !important;
  }
</style>
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

  <div class="card pd-20 pd-sm-40 mg-t-10">
    <p class="mg-b-20 mg-sm-b-30">Add & Organize categories for subjects and contents</p>
    <div class="btn-group mg-b-20" role="group" aria-label="Basic example">
      <a type="button" href="{{ route('add-category') }}" class="btn btn-secondary pd-x-25 active">
        Add New <i class="fa fa-plus" aria-hidden="true"></i>
      </a>
    </div>
    <div class="row">

      @foreach($categories as $item)
      <div class="col-lg-4 mg-t-30 mg-b-20 mg-t-20">
        <div class="card bd-0">
          <div class="card-header card-header-default bg-success justify-content-between">
            <h6 class="mg-b-0 tx-14 tx-white tx-normal">{{ $item->label ? $item->label : '' }}</h6>
            <div class="card-option tx-24">
              <a href="{{ route('edit-category', ['id' => $item->id]) }}" class="tx-white-8 hover-white mg-l-10"><i
                  class="fa fa-pencil lh-0"></i></a>
              <a href="{{ route('delete-category', ['id' => $item->id ]) }}" class="tx-danger hover-warning mg-l-10"><i
                  class="fa fa-times fa-xs lh-0"></i></a>
              {{-- <a href="#" class="tx-white-8 hover-white mg-l-10"><i class="icon ion-android-more-vertical lh-0"></i></a> --}}
            </div><!-- card-option -->
          </div><!-- card-header -->
          <div class="card-body bg-white-200">
            <div class="row">
              @if (isset($item->image ))
              <div class="col-lg-4">
                <img class="img-thumbnail" width="100%" height=200px" src="{{ $item->image ? $item->image : '' }}"
                  alt="">
              </div>
              {{-- <hr class="dashed"> --}}
              @endif
              <div class="col-lg-8">
                <p class="mg-b-0">
                  {{ $item->description ? str_limit($item->description, 75, '...') : $item->label . ' Category' }}
                </p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-12">
                <div class="col-lg-6">
                  <strong>Subjects: </strong>
                  {{ $item->subjects ? count($item->subjects) : '0' }}
                </div>
                <div class="col-lg-6">
                  <strong>Contents: </strong>
                  {{ $item->contents ? count($item->contents) : '0' }}
                </div>
                <div class="col-lg-12">
                  <strong>Last Updated: </strong>
                  {{ $item->updated_at ? $item->updated_at->diffForHumans() : '0' }}
                </div>
              </div>
            </div>


          </div>
          <!-- card-body -->

          {{-- <div class="card-footer bg-gray-300 d-flex justify-content-between">
                <a href="/admin/category/{{$item->id}}" class="btn btn-info">View</a>
        </div> --}}
      </div>
      <!-- card -->
    </div>
    @endforeach


  </div><!-- row -->

  <hr>

  <div class="btn-group mg-b-20" role="group" aria-label="Basic example">
    <a type="button" href="{{ route('add-category') }}" class="btn btn-secondary pd-x-25 active">
      Add New <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
  </div>

</div>

</div>
<style>
  a {
    text-transform: none;
    text-decoration: none;
    cursor: pointer;
  }
</style>
@stop