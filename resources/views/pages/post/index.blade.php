@extends('layouts.default') 

@section('title')
Posts
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

    <div class="content-wrapper">
        <!-- content-left -->
        <div class="content-body">
            <div class="btn-group mg-b-20" role="group" aria-label="Basic example">
                <a type="button" href="{{ route('post.create') }}" class="btn btn-secondary pd-x-25 active">
                  Add New <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>

            <!-- content-body-header -->

            <table class="table table-striped mg-b-0 mg-t-20">
                <thead>
                    <tr>
                      <th></th>
                        <th>Title</th>
                        <th class="hidden-xs-down">Publisher</th>
                        <th class="hidden-xs-down">Views</th>
                        <th class="hidden-xs-down">Last Updated</th>
                        <th class="wd-5p">Actions</th>
                    </tr>
                </thead>
                <tbody id="cat-tb-bdy">
                    @foreach($posts as $post)
                    <tr id="{{$post->id}}-post">
                      <td>
                      @if (isset($post->image) && $post->image !== '')
                      <a class="pull-left" href="#">
                        <img class="media-object" style="width: 40px; height:40px;"
                          src="{{ $post->image ? $post->image : '' }}">
                      </a>
                      @endif
                    </td>
                        <td>
                            <a href="{{ route('post.show', ['id' => $post->id]) }}">
                                <i class="fa fa-file-o tx-22 tx-danger lh-0 valign-middle"></i>
                                <span class="pd-l-5">{{ $post->title }}</span>
                            </a>
                        </td>
                        <td>
                          {{ isset($post->user) ? $post->user->name : '' }}
                        </td>
                        <td class="hidden-xs-down"><a href="{{ route('post.show', ['id' => $post->id]) }}">{{ isset($post->views) && $post->views !== '' ? $post->views : '0' }}</a></td>
                        <td class="hidden-xs-down"><a href="{{ route('post.show', ['id' => $post->id]) }}">{{ $post->updated_at ? $post->updated_at->diffForHumans() : 'Not defined' }}</a></td>

                        <td class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i
                                    class="icon ion-more"></i></a>
                            <div class="dropdown-menu dropdown-menu-right pd-10">
                                <nav class="nav nav-style-1 flex-column">

                                    <a href="{{ route('post.edit', ['id' => $post->id]) }}" class="nav-link">Edit</a>

                                    <a href="{{ route('post.destroy', ['id' => $post->id]) }}" class="nav-link danger">Delete</a>

                                </nav>
                            </div>
                            <!-- dropdown-menu -->
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- content-body -->
    </div>
    <!-- content-wrapper -->
</div>
<!-- kt-pagebody -->
<style>

    a {
        text-transform: none;
        text-decoration: none !important;
    }
    td a {
        text-decoration: none !important;
        color: inherit;
        font-weight: bolder;
    }
</style>
@stop
