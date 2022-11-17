@extends('layouts.default') @section('content')

<div class="kt-pagetitle">
    <h5>App Feedbacks</h5>
</div>

<div class="kt-pagebody">
    <div class="content-wrapper">
        <div class="content-left">
            <ul class="nav">
                <!-- nav-item -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="icon ion-ios-filing-outline"></i>
                        <span>Feedbacks</span>
                        <span class="mg-l-auto tx-12">{{ count(\App\Review::all()) }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- mailbox-left -->
        <div class="content-body">
            <div class="content-body-header">
                
                <div class="mg-l-auto">
                    {{ $reviews->links() }}
                </div>
            </div>
            <!-- mailbox-header -->

            <div class="list-group mailbox-list-group">
                <!-- loop starts here -->
                @if (count($reviews) > 0)                        
                    @foreach ($reviews as $review) 
                    <div class="list-group-item media align-items-center unread">
                        <label class="ckbox mg-b-0">
                            <input type="checkbox" /><span></span>
                        </label>
                        <div class="media-body mg-l-20">
                            <div class="media-body-head">
                                <div class="d-flex">
                                    <div>
                                        <img
                                            src="../img/avatar.jpg"
                                            class="wd-35 rounded-circle"
                                            alt=""
                                        />
                                    </div>
                                    <div class="mg-l-10">
                                        <h6 class="tx-inverse tx-13 mg-b-2">
                                            {{ $review->name }}
                                        </h6>
                                        <span class="d-block tx-12"
                                            >{{ $review->created_at->diffForHumans() }}</span
                                        >
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mg-r-5">
                                    @for ($i = 0; $i < $review->rating; $i++)
                                <a href="#" class="mg-r-5" title="{{ $review->rating > 1 ? $review->rating . " stars" : $review->rating . " star"}}"><i class="icon ion-star tx-18"></i></a>
                                    @endfor
                                    
                                </div>
                            </div>
                            <p class="tx-inverse mg-b-0 tx-13">
                                {{ $review->message }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                @else
                    
                @endif
                <!-- list-group-item -->
            </div>

            <br>
            <div class="content-body">
                <div class="content-body-header">
                    <div class="mg-l-auto">
                        {{ $reviews->links() }}
                    </div>
                </div>

            <!-- list-group -->
        </div>
        <!-- content-body -->
    </div>
    <!-- content-wrapper -->
</div>
<script src="{{ asset('js/axios.min.js') }}"></script>

@stop
