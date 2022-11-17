@extends('layouts.default') 

@section('title')
My Profile
@endsection

@section('content')
<div class="kt-pagetitle">
    <h5>My Profile</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
    <div class="row">
        <div class="col-md-4 col-lg-3">
            <label class="content-left-label">Your Profile Photo</label>
            <figure class="edit-profile-photo">
                <img src="../img/avatar.jpg" class="img-fluid" alt="" />
                <figcaption>
                    <a href="#" class="btn btn-dark">Edit Photo</a>
                </figcaption>
            </figure>

            <label class="content-left-label mg-t-30">Your Tags</label>
            <ul class="edit-profile-tag-list">
                <li>
                    <span>Admin</span>
                    <a href="#"
                        ><i class="icon ion-ios-close-empty tx-20"></i
                    ></a>
                </li>
            </ul>
        </div>
        <!-- col-3 -->
        <div class="col-md-8 col-lg-9 mg-t-30 mg-md-t-0">
            {{-- <label class="content-left-label">Login Information</label>
            <div class="card bg-gray-200 bd-0">
                <div class="edit-profile-form">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label"
                            >Username: <span class="tx-danger">*</span></label
                        >
                        <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                            <input
                                class="form-control"
                                placeholder="Enter username"
                                type="text"
                                value="your.username"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label"
                            >Email: <span class="tx-danger">*</span></label
                        >
                        <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                            <input
                                class="form-control"
                                placeholder="Enter username"
                                type="email"
                                value="yourname@yourdomain.com"
                            />
                        </div>
                    </div>
                    <div class="form-group row mg-b-0">
                        <label class="col-sm-3 form-control-label"
                            >Password:</label
                        >
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <a href="#">Change Password</a>
                        </div>
                    </div>
                </div>
                <!-- wd-60p -->
            </div>
            <!-- card -->
            --}} {{--
            <hr class="invisible" />
            --}}

            <label class="content-left-label">Personal Information</label>
            <div class="card bg-gray-200 bd-0">
                <div class="edit-profile-form">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Name:</label>
                        <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                            <input class="form-control type="text"
                            id="user_name">
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label"
                            >Email:</label
                        >
                        <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                            <input
                                class="form-control"
                                placeholder="Enter lastname"
                                type="text"
                                id="email"
                            />
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label"
                            >Location:</label
                        >
                        <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                            <input
                                class="form-control"
                                placeholder="Location"
                                type="text"
                                value="Nigeria"
                                id="location"
                            />
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Role</label>
                        <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                            <input
                                class="form-control"
                                placeholder="Role"
                                type="text"
                                id="role"
                            />
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label"
                            >Status</label
                        >
                        <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                            <input
                                class="form-control"
                                placeholder="Status"
                                type="text"
                                id="status"
                            />
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group row col-10">
                        <button class="form-control" id="edit-profile-button">
                            Edit Profile <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <!-- wd-60p -->
            </div>
            <!-- card -->

            <hr class="invisible" />

            {{-- <label class="content-left-label">Notifications</label>
            <div class="card pd-40 bg-gray-200 bd-0">
                <div>
                    <label class="ckbox">
                        <input type="checkbox" /><span
                            >Email me when someone mentions me...</span
                        >
                    </label>
                </div>
                <div>
                    <label class="ckbox">
                        <input type="checkbox" /><span
                            >Email me when someone follows me...</span
                        >
                    </label>
                </div>
            </div>
            <!-- card -->
            --}}
        </div>
        <!-- col-9 -->
    </div>
    <!-- row -->
</div>
<!-- kt-pagebody -->
<script>
    let name = document.getElementById("user_name");
    let email = document.getElementById("email");
    let role = document.getElementById("role");
    let status = document.getElementById("status");

    name ? (name.value = localStorage.getItem("name")) : null;
    email ? (email.value = localStorage.getItem("email")) : null;
    role ? (role.value = localStorage.getItem("type")) : null;
    status ? (status.value = localStorage.getItem("status")) : null;
</script>
@stop
