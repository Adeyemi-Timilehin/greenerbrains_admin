<div class="kt-headpanel">
    <div class="kt-headpanel-left">
        <a id="naviconMenu" href="#" class="kt-navicon d-none d-lg-flex"
            ><img
                src="http://qbgrow.com/magen/iot-admin/img/menu.svg"
                width="30"
        /></a>
        <a id="naviconMenuMobile" href="#" class="kt-navicon d-lg-none"
            ><i class="icon ion-navicon-round"></i
        ></a>
    </div>
    <!-- kt-headpanel-left -->

    <div class="kt-headpanel-right">
        {{--
        <div class="dropdown dropdown-notification">
            <a
                href="#"
                class="nav-link pd-x-7 pos-relative"
                data-toggle="dropdown"
            >
                <img
                    src="http://qbgrow.com/magen/iot-admin/img/notification.svg"
                    height="24"
                />
                <!-- start: if statement -->
                <span
                    class="square-8 bg-danger pos-absolute t-15 r-0 rounded-circle"
                ></span>
                <!-- end: if statement -->
            </a>
            <div class="dropdown-menu wd-300 pd-0-force">
                <div class="dropdown-menu-header">
                    <label>Notifications</label>
                    <a href="#">Mark All as Read</a>
                </div>
                <!-- d-flex -->

                <div class="media-list">
                    <!-- loop starts here -->
                    <a href="#" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img
                                src="{{asset('img/img8.jpg"
                                class="wd-40 rounded-circle') }}"
                                alt=""
                            />
                            <div class="media-body">
                                <p class="tx-13 mg-b-0">
                                    <strong class="tx-medium"
                                        >Suzzeth Bungaos</strong
                                    >
                                    tagged you and 18 others in a post.
                                </p>
                                <span class="tx-12"
                                    >October 03, 2017 8:45am</span
                                >
                            </div>
                        </div>
                        <!-- media -->
                    </a>
                    <!-- loop ends here -->
                    <a href="#" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img
                                src="{{ asset('img/img9.jpg') }}"
                                class="wd-40 rounded-circle"
                                alt=""
                            />
                            <div class="media-body">
                                <p class="tx-13 mg-b-0">
                                    <strong class="tx-medium"
                                        >Mellisa Brown</strong
                                    >
                                    appreciated your work
                                    <strong class="tx-medium"
                                        >The Social Network</strong
                                    >
                                </p>
                                <span class="tx-12"
                                    >October 02, 2017 12:44am</span
                                >
                            </div>
                        </div>
                        <!-- media -->
                    </a>
                    <a href="#" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img
                                src="{{ asset('img/img10.jpg') }}"
                                class="wd-40 rounded-circle"
                                alt=""
                            />
                            <div class="media-body">
                                <p class="tx-13 mg-b-0">
                                    20+ new items added are for sale in your
                                    <strong class="tx-medium"
                                        >Sale Group</strong
                                    >
                                </p>
                                <span class="tx-12"
                                    >October 01, 2017 10:20pm</span
                                >
                            </div>
                        </div>
                        <!-- media -->
                    </a>
                    <a href="#" class="media-list-link read">
                        <div class="media pd-x-20 pd-y-15">
                            <img
                                src="{{ asset('img/img5.jpg') }}"
                                class="wd-40 rounded-circle"
                                alt=""
                            />
                            <div class="media-body">
                                <p class="tx-13 mg-b-0">
                                    <strong class="tx-medium"
                                        >Julius Erving</strong
                                    >
                                    wants to connect with you on your
                                    conversation with
                                    <strong class="tx-medium"
                                        >Ronnie Mara</strong
                                    >
                                </p>
                                <span class="tx-12"
                                    >October 01, 2017 6:08pm</span
                                >
                            </div>
                        </div>
                        <!-- media -->
                    </a>
                    <div class="media-list-footer">
                        <a href="#" class="tx-12"
                            ><i class="fa fa-angle-down mg-r-5"></i> Show All
                            Notifications</a
                        >
                    </div>
                </div>
                <!-- media-list -->
            </div>
            <!-- dropdown-menu -->
        </div>
        <!-- dropdown -->
        --}}
        <div class="dropdown dropdown-profile">
            <a
                href="#"
                class="nav-link nav-link-profile"
                data-toggle="dropdown"
            >
                <img
                    src="{{ Auth::user()->image ? Auth::user()->image : asset('img/img3.jpg') }}"
                    class="wd-32 rounded-circle"
                    alt="{{ Auth::user()->name }} "
                />
                <span class="logged-name">
                    <b><span class="hidden-xs-down" id="profile_name">{{ str_limit(Auth::user()->name, 2) }}</span></b>
                    <i class="fa fa-angle-down mg-l-3"></i>
                </span>
            </a>
            <div class="dropdown-menu wd-200">
                <ul class="list-unstyled user-profile-nav">
                    <li>
                        <a href="{{ route('profile') }}"
                            ><i class="icon ion-ios-person-outline"></i>
                            Profile</a
                        >
                    </li>
                    {{--
                    <li>
                        <a href="#"
                            ><i class="icon ion-ios-gear-outline"></i>
                            Settings</a
                        >
                    </li>
                    --}} {{--
                    <li>
                        <a href="#"
                            ><i class="icon ion-ios-download-outline"></i>
                            Downloads</a
                        >
                    </li>
                    --}} {{--
                    <li>
                        <a href="#"
                            ><i class="icon ion-ios-star-outline"></i>
                            Favorites</a
                        >
                    </li>
                    --}}
                    <li>
                        <a href="{{ route('content') }}"
                            ><i class="icon ion-ios-folder-outline"></i>
                            Collections</a
                        >
                    </li>
                    <li>
                    <a href="{{ route('logout') }}"><i class="icon ion-power"></i> Sign Out</a>
                    </li>
                </ul>
            </div>
            <!-- dropdown-menu -->
        </div>
        <!-- dropdown -->
    </div>
    <!-- kt-headpanel-right -->
</div>
<!-- kt-headpanel -->
<script>
    // Logout Handler
    let signout = document.getElementById("signout");
    signout
        ? signout.addEventListener("click", e => {
              e.preventDefault();
              API.logout();
          })
        : null;

    let p_name = document.getElementById("profile_name");

    p_name ? (p_name.innerText = localStorage.getItem("name")) : null;
</script>
