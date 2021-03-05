@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
    <!-- page user profile start -->
    <section class="page-user-profile">
        <div class="row">
            <div class="col-12">
                <!-- user profile heading section start -->
                <div class="card">
                    <div class="card-content">
                        <div class="user-profile-images">
                            <!-- user timeline image -->
                            <img src="{{ admin_link('frest-admin/app-assets/images/profile/post-media/profile-banner-2.png') }}"
                                 class="img-fluid rounded-top user-timeline-image" alt="user timeline image">
                            <!-- user profile image -->
                            <img src="{{ \ImageURL::getImageUrl(@$user->avatar, 'user', 'large') }}"
                                 class="user-profile-image rounded"
                                 alt="user profile image" height="140" width="140">
                        </div>
                        <div class="user-profile-text">
                            <h4 class="mb-0 text-bold-500 profile-text-color">{{ \Auth::user()->fullname }}</h4>
                        </div>
                        <!-- user profile nav tabs start -->
                        <div class="card-body px-0">
                            <ul class="nav user-profile-nav justify-content-center justify-content-md-start nav-tabs border-bottom-0 mb-0"
                                role="tablist">
                                <li class="nav-item pb-0">
                                    <a class="nav-link d-flex px-1 active" id="activity-tab" data-toggle="tab"
                                       href="#activity"
                                       aria-controls="activity" role="tab" aria-selected="false">
                                        <i class="bx bx-user"></i><span
                                                class="d-none d-md-block">Nhật ký hoạt động</span></a>
                                </li>
                            </ul>
                        </div>
                        <!-- user profile nav tabs ends -->
                    </div>
                </div>
                <!-- user profile heading section ends -->

                <!-- user profile content section start -->
                <div class="row">
                    <!-- user profile nav tabs content start -->
                    <div class="col-lg-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="activity" aria-labelledby="activity-tab" role="tabpanel">
                                <!-- user profile nav tabs activity start -->
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- timeline widget start -->
                                            <ul class="widget-timeline" id="timeline">
                                                @if ($lsObj->total() > 0)
                                                @foreach($lsObj as $obj)
                                                    <li class="timeline-items timeline-icon-success active">
                                                        <div class="timeline-time">{{ \Lib::dateFormat(@$obj['created'], 'H:i:s d/m/Y') }}</div>
                                                        <h6 class="timeline-title">{{ $user->fullname }}</h6>
                                                        <p class="timeline-text"><a
                                                                    href="{{ $obj->url }}">{{ $obj->getAction() }}</a>
                                                        </p>
                                                        {{--<div class="timeline-content">
                                                            Welcome to vedio game and lame is very creative
                                                        </div>--}}
                                                    </li>
                                                @endforeach
                                                @else

                                                @endif
                                            </ul>
                                            <!-- timeline widget ends -->
                                            @if ($lsObj->hasMorePages())
                                                <div class="text-center">
                                                    <button type="button"
                                                            data-page="{{ $lsObj->currentPage()+1 }}"
                                                            data-link="{{ url()->full() }}?seeMore=true&page=" data-div="#timeline" class="btn see-more btn-primary">Xem thêm</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- user profile nav tabs activity start -->
                            </div>
                        </div>
                    </div>
                    <!-- user profile nav tabs content ends -->
                    <!-- user profile right side content start -->
                    <div class="col-lg-3">
                        <!-- user profile right side content birthday card start -->
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="d-inline-flex">
                                        <div class="avatar mr-50">
                                            <img src="{{ \ImageURL::getImageUrl(@$user->avatar, 'user', 'small') }}"
                                                 alt="avtar images" height="32"
                                                 width="32">
                                        </div>
                                        <h6 class="mb-0 d-flex align-items-center"> Thông tin cá nhân</h6>
                                    </div>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-flex mb-25">
                                            <i class="cursor-pointer bx bx-trending-up text-primary mr-50 mt-25"></i>
                                            <span>
                                                <a href="{{ @$user->facebook?:'javascrip:void(0);' }}" target="_blank" class="mr-50">#Facebook</a>
                                            </span>
                                        </li>
                                        <li class="d-flex mb-25">
                                            <i class="cursor-pointer bx bx-trending-up text-primary mr-50 mt-25"></i>
                                            <span>
                                                <a href="{{ @$user->twitter?:'javascrip:void(0);' }}" target="_blank" class="mr-50">#Twitter</a>
                                            </span>
                                        </li>
                                        <li class="d-flex mb-25">
                                            <i class="cursor-pointer bx bx-trending-up text-primary mr-50 mt-25"></i>
                                            <span>
                                                <a href="{{ @$user->instagram?:'javascrip:void(0);' }}" target="_blank" class="mr-50">#Instagram</a>
                                            </span>
                                        </li>
                                        <li class="d-flex mb-25">
                                            <i class="cursor-pointer bx bx-trending-up text-primary mr-50 mt-25"></i>
                                            <span>
                                                <a href="{{ @$user->google_plus?:'javascrip:void(0);' }}" target="_blank" class="mr-50">#Google+</a>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- user profile right side content ends -->
                </div>
                <!-- user profile content section start -->
            </div>
        </div>
    </section>
    <!-- page user profile ends -->
@endsection


@section('CSS_REGION')
    {!! \Lib::addMedia('admin/frest-admin/app-assets/css/pages/page-user-profile.min.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/extensions/swiper.min.css') !!}
@stop


@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/extensions/swiper.min.js') !!}
    <script type="text/javascript">
        $(document).ready(function () {
            $(".user-profile-like").click(function () {
                $(this).toggleClass("bx-heart bxs-heart").toggleClass("text-danger")
            });
            var e = $(".swiper-slide").length;
            e && (e = Math.floor(e / 2));
            new Swiper(".user-profile-stories", {
                slidesPerView: "auto",
                initialSlide: e,
                centeredSlides: !0,
                spaceBetween: 15
            })
            $(".see-more").click(function() {
                $div = $($(this).attr('data-div')); //div to append
                $link = $(this).attr('data-link'); //current URL

                $page = $(this).attr('data-page'); //get the next page #
                $href = $link + $page; //complete URL
                $.get($href, function(response) { //append data
                    if(response.error == 0) {
                        var arr = response.data
                        let html = ''
                        let user_fullname = '{{ $user->fullname }}';
                        for (let i in arr) {
                            html += '<li class="timeline-items timeline-icon-success active">\n' +
                                '        <div class="timeline-time">'+arr[i]['created']+'</div>\n' +
                                '        <h6 class="timeline-title">'+user_fullname+'</h6>\n' +
                                '        <p class="timeline-text"><a\n' +
                                '            href="'+arr[i]['url']+'">'+arr[i]['action']+'</a>\n' +
                                '         </p>\n' +
                                '     </li>'
                        }
                        $div.append(html);
                    }
                });

                $(this).attr('data-page', (parseInt($page) + 1)); //update page #
            });
        });
    </script>
@endpush