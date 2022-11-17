@extends('layouts.default') 

@section('title')
User Messages
@endsection

@section('content')

<div class="kt-pagetitle">
    <h5>Contact Us Mailbox</h5>
</div>
<div class="kt-pagebody">
    @if(isset($message))
    <script>
        document.addEventListener("DOMContentLoaded", event => {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "successful",
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
                title: "Successful",
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
                title: "Unsuccessful",
                showConfirmButton: false,
                timer: 2500
            });
        });
    </script>
    @endif


    <div class="kt-pagebody">
        <div class="content-wrapper">
            <div class="content-left">
                {{-- <a href="#" class="btn btn-teal btn-block bd-0 ht-40">Compose New</a> --}}

                <ul class="nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <i class="icon ion-ios-filing-outline"></i>
                            <span>Inbox</span>
                            <span class="mg-l-auto tx-12">{{ count(\App\Contact::all()) }}</span>
                        </a>
                    </li>
                    <!-- nav-item -->
                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon ion-ios-paperplane-outline"></i>
                            <span>Sent</span>
                        </a>
                    </li> --}}
                </ul>
            </div>
            <!-- mailbox-left -->
            <div class="content-body">
                <div class="content-body-header">
                    <div class="mg-l-auto">
                        {{ $contact_messages->links() }}
                        <!-- btn-group -->
                    </div>
                </div>
                <!-- mailbox-header -->

                <div class="list-group mailbox-list-group">
                    <!-- loop starts here -->
                    @if (count($contact_messages) > 0)                        
                        @foreach ($contact_messages as $message) 
                            <div class="list-group-item media align-items-center unread">
                                <label class="ckbox mg-b-0">
                                    <input type="checkbox" /><span></span>
                                </label>
                                <div class="media-body mg-l-20">
                                    <div class="media-body-head">
                                        <div class="d-flex">
                                            <div>
                                                <img src="../img/avatar.jpg" class="wd-35 rounded-circle" alt="" />
                                            </div>
                                            <div class="mg-l-10">
                                                <h6 class="tx-inverse tx-13 mg-b-2">
                                                    {{ $message->name }}
                                                </h6>
                                                <span class="d-block tx-12">{{ $message->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="/admin/message/{{ $message->id }}">
                                        <h6 class="tx-inverse tx-14 mg-b-0">
                                            {{ $message->subject }}
                                        </h6>
                                        <p class="mg-b-0 tx-13">
                                            {{ str_limit($message->body, 100) }}
                                        </p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        
                    @endif
                    <!-- list-group-item -->
                </div>
                <!-- list-group -->

                <div class="content-body-header">
                    <div class="mg-l-auto">
                        <br>
                        {{ $contact_messages->links() }}
                        <!-- btn-group -->
                    </div>
                </div>

            </div>
            <!-- content-body -->
        </div>
        <!-- content-wrapper -->
    </div>
    <script src="{{ asset('js/axios.min.js') }}"></script>

    @stop