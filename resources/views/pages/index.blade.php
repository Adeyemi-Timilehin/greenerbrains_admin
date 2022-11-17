@extends('layouts.default')

@section('title')
Dashboard
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


  <div class="row row-sm">
    <div class="col-lg-8">
      <div class="row row-sm">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body pd-b-0">
              {{-- <img src="../img/senc.svg" class="card-icon" width="60"> --}}
              <h6 class="card-body-title tx-12 tx-spacing-2 mg-b-20">courses</h6>
              <h2 class="tx-roboto tx-inverse">{{ count(\App\Subject::all()) }} <small>Courses</small></h2>
              <p class="tx-12"><span class="tx-success">2.5%</span> stability from yesterday</p>
            </div><!-- card-body -->
          </div><!-- card -->
        </div><!-- col-6 -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body pd-b-0">
              {{-- <img src="../img/energy.svg" class="card-icon" width="60"> --}}
              <h6 class="card-body-title tx-12 tx-spacing-2 mg-b-20">content</h6>
              <h2 class="tx-roboto tx-inverse">{{ count(\App\Content::all()) }} <small>Contents</small></h2>
              <p class="tx-12"><span class="tx-success">2.5%</span> change from yesterday</p>
            </div><!-- card-body -->
          </div><!-- card -->
        </div><!-- col-6 -->
      </div><!-- row -->

      <div class="row row-sm">
        <div class="col-lg-6">
          <div class="card mg-t-20">
            <div class="card-body pd-b-0 ">
              {{-- <img src="../img/senc.svg" class="card-icon" width="60"> --}}
              <h6 class="card-body-title tx-12 tx-spacing-2 mg-b-20">blog</h6>
              <h2 class="tx-lato tx-inverse">{{ count(\App\Post::all()) }} <small>Blog Post</small></h2>
              <p class="tx-12"><span class="tx-success">2.5%</span> change from yesterday</p>
            </div><!-- card-body -->
          </div><!-- card -->
        </div><!-- col-6 -->
        <div class="col-lg-6 mg-t-20">
          <div class="card">
            <div class="card-body pd-b-0">
              {{-- <img src="../img/rain.svg" class="card-icon" width="60"> --}}
              <h6 class="card-body-title tx-12 tx-spacing-2 mg-b-20">users</h6>
              <h2 class="tx-roboto tx-inverse">{{ count(\App\User::all()) }} <small>Users</small></h2>
              <p class="tx-12"><span class="tx-success">2.5%</span> change from yesterday</p>
            </div><!-- card-body -->
          </div><!-- card -->
        </div><!-- col-6 -->
      </div><!-- row -->

      <div class="row row-sm">
        <div class="col-lg-6">
          <div class="card mg-t-20">
            <div class="card-body pd-b-0 ">
              {{-- <img src="../img/senc.svg" class="card-icon" width="60"> --}}
              <h6 class="card-body-title tx-12 tx-spacing-2 mg-b-20">category</h6>
              <h2 class="tx-lato tx-inverse">{{ count(\App\Category::all()) }} <small>Categories</small></h2>
              <p class="tx-12"><span class="tx-success">2.5%</span> change from yesterday</p>
            </div><!-- card-body -->
          </div><!-- card -->
        </div><!-- col-6 -->
        <div class="col-lg-6 mg-t-20">
          <div class="card">
            <div class="card-body pd-b-0">
              {{-- <img src="../img/rain.svg" class="card-icon" width="60"> --}}
              <h6 class="card-body-title tx-12 tx-spacing-2 mg-b-20">tags</h6>
              <h2 class="tx-roboto tx-inverse">{{ count(\App\Tag::all()) }} <small>Categories</small></h2>
              <p class="tx-12"><span class="tx-success">2.5%</span> change from yesterday</p>
            </div><!-- card-body -->
          </div><!-- card -->
        </div><!-- col-6 -->
      </div><!-- row -->



    </div><!-- col-8 -->
    <div class="col-lg-4">

      <div class="card mg-t-20">
        <div class="card-header d-flex justify-content-between">
          <span class="tx-uppercase tx-12 tx-medium tx-inverse">Recent Messages</span>
          <a href="" class="tx-gray-600"><i class="icon ion-more"></i></a>
        </div><!-- card-header -->
        <div class="list-group list-group-flush">

          @foreach (\App\Contact::orderBy('created_at', 'desc')->limit(4)->get() as $contact)
           <div class="list-group-item">
            <div class="media">
              <img src="../img/avatar.jpg" class="wd-30 rounded-circle" alt="">
              <div class="media-body mg-l-10">
                <h6 class="mg-b-0 tx-inverse tx-13">{{ isset($contact->name) ? $contact->name : '' }}</h6>
                <p class="mg-b-0 tx-gray-500 tx-12">{{ isset($contact->created_at) ? $contact->created_at->diffForHumans() : '' }}</p>
              </div><!-- media-body -->
            </div><!-- media -->
            <p class="mg-t-10 mg-b-0 tx-13">{{ isset($contact->body) ? str_limit($contact->body, 100, '...') : '' }}</p>
          </div>   
          @endforeach
          
          <!-- list-group-item -->
        </div><!-- list-group -->
        <div class="card-footer">
        <a href="{{ route('messages') }}" class="tx-12"><i class="fa fa-angle-down mg-r-5"></i> Show all messages</a>
        </div><!-- card-footer -->
      </div><!-- card -->

    </div><!-- col-4 -->
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