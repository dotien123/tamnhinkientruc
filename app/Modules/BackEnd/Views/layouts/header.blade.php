<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed bg-primary navbar-brand-center {{ @$theme_customizer->navbar_colors }}">
    <div class="navbar-header d-xl-block d-none">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item"><a class="navbar-brand" href="{{ route('admin.home') }}">
                    <div class="brand-logo"><img class="logo" src="{{ admin_link('frest-admin/app-assets/images/logo/logo-light.png') }}"></div>
                    <h2 class="brand-text mb-0">CMS {{ env('APP_NAME') }}</h2></a></li>
        </ul>
    </div>
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu mr-auto"><a class="nav-link nav-menu-main menu-toggle" href="#"><i class="bx bx-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                    @foreach ($menuLeft as $k => $menu)
                        @if($k == '_99999999999')
                            @php($show=false)
                            @if(!empty($menu['perm']))
                                @can($menu['perm'], $menu['perm'])
                                    @php($show=true)
                                @endcan
                            @else
                                @php($show=true)
                            @endif
                            @if($show)
                                @if(!empty($menu['sub']))
                                    @foreach ($menu['sub'] as $sub)
                                        @php($show=false)
                                        @if(!empty($sub['perm']))
                                            @can($sub['perm'], $sub['perm'])
                                                @php($show=true)
                                            @endcan
                                        @else
                                            @php($show=true)
                                        @endif

                                        @if($show)
                                            @if(empty($sub['sub']))
                                                <!-- item-->
                                                    <li class="nav-item d-none d-lg-block">
                                                        <a class="nav-link" href="{{ $sub['link']!='' ? $sub['link'] : 'javascript:void(0)' }}"
                                                           @if($sub['link']!='' && $sub['newtab'] == 1) target="_blank"@endif data-toggle="tooltip" data-placement="top" title="{{ $sub['title'] }}">
                                                            @if (!empty($sub['icon'])) <i class="{{ $sub['icon'] }} ficon bx bx-chat"></i> @endif
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    @else


                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </ul>

                    {{--<ul class="nav navbar-nav">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon bx bx-star warning"></i></a>
                            <div class="bookmark-input search-input">
                                <div class="bookmark-input-icon"><i class="bx bx-search primary"></i></div>
                                <input class="form-control input" type="text" placeholder="Explore Frest..." tabindex="0" data-search="template-search">
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                    </ul>--}}
                </div>
                <ul class="nav navbar-nav float-right d-flex align-items-center">

                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
{{--                    <li class="nav-item nav-search"><a class="nav-link nav-link-search pt-2"><i class="ficon bx bx-search"></i></a>--}}
{{--                        <div class="search-input">--}}
{{--                            <div class="search-input-icon"><i class="bx bx-search primary"></i></div>--}}
{{--                            <input class="input" type="text" placeholder="Explore Frest..." tabindex="-1" data-search="template-search">--}}
{{--                            <div class="search-input-close"><i class="bx bx-x"></i></div>--}}
{{--                            <ul class="search-list"></ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}
                    {{--<li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up">5</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title">7 new Notification</span><span class="text-bold-400 cursor-pointer">Mark all as read</span></div>
                            </li>
                            <li class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0"><img src="{{ admin_link('frest-admin/app-assets/images/portrait/small/avatar-s-11.jpg') }}" alt="avatar" height="39" width="39"></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">Congratulate Socrates Itumay</span> for work anniversaries</h6><small class="notification-text">Mar 15 12:32pm</small>
                                        </div>
                                    </div></a>
                                <div class="d-flex justify-content-between read-notification cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0"><img src="{{ admin_link('frest-admin/app-assets/images/portrait/small/avatar-s-16.jpg') }}" alt="avatar" height="39" width="39"></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">New Message</span> received</h6><small class="notification-text">You have 18 unread messages</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center py-0">
                                        <div class="media-left pr-0"><img class="mr-1" src="{{ admin_link('frest-admin/app-assets/images/icon/sketch-mac-icon.png') }}" alt="avatar" height="39" width="39"></div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">Updates Available</span></h6><small class="notification-text">Sketch 50.2 is currently newly added</small>
                                        </div>
                                        <div class="media-right pl-0">
                                            <div class="row border-left text-center">
                                                <div class="col-12 px-50 py-75 border-bottom">
                                                    <h6 class="media-heading text-bold-500 mb-0">Update</h6>
                                                </div>
                                                <div class="col-12 px-50 py-75">
                                                    <h6 class="media-heading mb-0">Close</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-primary bg-lighten-5 mr-1 m-0 p-25"><span class="avatar-content text-primary font-medium-2">LD</span></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">New customer</span> is registered</h6><small class="notification-text">1 hrs ago</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="cursor-pointer">
                                    <div class="media d-flex align-items-center justify-content-between">
                                        <div class="media-left pr-0">
                                            <div class="media-body">
                                                <h6 class="media-heading">New Offers</h6>
                                            </div>
                                        </div>
                                        <div class="media-right">
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input" type="checkbox" checked id="notificationSwtich">
                                                <label class="custom-control-label" for="notificationSwtich"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-danger bg-lighten-5 mr-1 m-0 p-25"><span class="avatar-content"><i class="bx bxs-heart text-danger"></i></span></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">Application</span> has been approved</h6><small class="notification-text">6 hrs ago</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between read-notification cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0"><img src="{{ admin_link('frest-admin/app-assets/images/portrait/small/avatar-s-4.jpg') }}" alt="avatar" height="39" width="39"></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">New file</span> has been uploaded</h6><small class="notification-text">4 hrs ago</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">Finance report</span> has been generated</h6><small class="notification-text">25 hrs ago</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center border-0">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0"><img src="{{ admin_link('frest-admin/app-assets/images/portrait/small/avatar-s-16.jpg') }}" alt="avatar" height="39" width="39"></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">New customer</span> comment recieved</h6><small class="notification-text">2 days ago</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">Read all notifications</a></li>
                        </ul>
                    </li>--}}
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-lg-flex d-none"><span class="user-name">{{ Auth::user()->fullname }}</span><span class="user-status">Online</span></div><span><img class="round user-avatar" src="{{ \Lib::get_gravatar(Auth::user()->email, 40) }}" alt="{{Auth::user()->fullname}}" height="40" width="40"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pb-0"><a class="dropdown-item" href="{{ route("admin.user.profile") }}"><i class="bx bx-user mr-50"></i> Trang cá nhân</a><a class="dropdown-item" href="javascript:void(0);" onclick="shop.admin.showChangePasswordForm()"><i class="bx bx-envelope mr-50"></i> Đổi mật khẩu</a>
                            <div class="dropdown-divider mb-0"></div><a class="dropdown-item" href="{{ route('logout') }}"  onclick="return confirm('Bạn có chắc chắn muốn thoát khỏi phiên đăng nhập?')"><i class="bx bx-power-off mr-50"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->

@include("BackEnd::layouts.menu")