@extends('layouts.default') 

@section('title')
List Subjects
@endsection

@section('content')
<style>
    .content-body {
        margin: 0px !important;
    }
</style>
<div class="kt-pagetitle">
    <h5>Subjects</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
    @if(Session::has('error'))
    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{!! Session::get('error') !!}</p>
    @endif

    @if(Session::has('success'))
    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
    @endif

    @if(isset($message))
    <script>
        document.addEventListener("DOMContentLoaded", event => {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ $message }}",
                showConfirmButton: false,
                timer: 2500
            });
        });
    </script>
    @endif
    @if(isset($success))
    <script>
        document.addEventListener("DOMContentLoaded", event => {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your subject has been saved",
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

    @if (isset($subjects))
    <div class="content-wrapper">
        <!-- content-left -->
        <div class="content-body">
            <div class="btn-group mg-b-20" role="group" aria-label="Basic example">
                <a type="button" href="/admin/subject/create" class="btn btn-secondary pd-x-25 active">
                    Add New <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>

            <!-- content-body-header -->
            <div class="content-body-header">

              <div class="mg-l-auto">
                {{ $subjects->links() }}
                <!-- btn-group -->
              </div>
            </div>

            <table class="table table-striped mg-b-0 mg-t-20">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="hidden-xs-down">Price</th>
                        <th class="hidden-xs-down">Content Count</th>
                        <th class="hidden-xs-down">Last Updated</th>
                        <th class="wd-5p"></th>
                    </tr>
                </thead>
                <tbody id="cat-tb-bdy">
                    @foreach($subjects as $item)


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
        </div>
        <div class="content-body-header">
          <div class="mg-l-auto">
            {{ $subjects->links() }}
          </div>
        </div>
        <!-- content-body -->
    </div>
    @endif
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
