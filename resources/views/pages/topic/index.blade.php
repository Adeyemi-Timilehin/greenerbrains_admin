@extends('layouts.default') @section('content')
<style>
    .content-body {
        margin: 0px !important;
    }

</style>
<div class="kt-pagetitle">
    <h5>Content Topics</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
    @if(isset($success))
        <h1>Success</h1>
        <script>
            Swal.fire({
                position: "top-end"
                , icon: "success"
                , title: "{{$success}}"
                , showConfirmButton: false
                , timer: 1500
            });

        </script>
        @endif

    <div class="content-wrapper">
        <!-- content-left -->
        <div class="content-body">
            <div class="btn-group mg-b-20" role="group" aria-label="Basic example">
                <a
                    type="button"
                    href="/admin/topic/create"
                    class="btn btn-secondary pd-x-25 active"
                >
                    Add New  <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>


            <table class="table table-striped mg-b-0 mg-t-20">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="hidden-xs-down">Modified</th>
                        <th class="wd-5p"></th>
                    </tr>
                </thead>
                <tbody id="cat-tb-bdy">
                    @foreach($topics as $item)

                    <tr id="{{$item->name}}-category">

                        <td>
                            <i class="fa fa-file-o tx-22 tx-danger lh-0 valign-middle"></i>
                            <span class="pd-l-5">{{ $item->label }}</span>

                        </td>
                        <td class="hidden-xs-down">{{ $item->created_at }}</td>

                        <td class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info"><i class="icon ion-more"></i></a>
                            <div class="dropdown-menu dropdown-menu-right pd-10">
                                <nav class="nav nav-style-1 flex-column">

                                    <a href="/admin/topic/{{ $item->id }}/edit" class="nav-link">Edit</a>

                                    <a href="/admin/topic/{{ $item->id }}/delete" class="nav-link">Delete</a>

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
<script>
    document.addEventListener("DOMContentLoaded", event => {
        window.API.loadCategories().then(r => {
            for (var i = 0; i < r.length; i++) {
                $("#cat-tb-bdy").append(
                    `<tr id="${r[i]["name"]}-category">
                        <td>
                            <i
                                class="fa fa-file-o tx-22 tx-danger lh-0 valign-middle"
                            ></i>
                            <span class="pd-l-5">${r[i]["label"]}</span>
                        </td>
                        <td class="hidden-xs-down">${r[i]["created_at"]}</td>
                        <td class="dropdown">
                            <a
                                href="#"
                                data-toggle="dropdown"
                                class="btn pd-y-3 tx-gray-500 hover-info"
                                ><i class="icon ion-more"></i
                            ></a>
                            <div
                                class="dropdown-menu dropdown-menu-right pd-10"
                            >
                                <nav class="nav nav-style-1 flex-column">
                                    <a
                                        href="/admin/topic/${r[i]["name"]}"
                                        class="nav-link"
                                        >Info</a
                                    >
                                    <a
                                        href="/admin/topic/${r[i]["name"]}/edit"
                                        class="nav-link"
                                        >Rename</a
                                    >
                                    <a
                                        href="/admin/topic/${r[i]["name"]}"
                                        class="nav-link"
                                        >Delete</a
                                    >
                                </nav>
                            </div>
                            <!-- dropdown-menu -->
                        </td>
                    </tr>`
                );
            }
        });
    });

</script>
@stop
