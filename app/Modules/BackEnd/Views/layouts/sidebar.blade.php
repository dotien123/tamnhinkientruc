<!-- Right Sidebar -->
<div class="right-bar">
    <div class="page-wrapper chiller-theme toggled">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="javascript:void(0);">Tiện ích</a>
                    <div id="close-sidebar">
                        <a href="javascript:void(0);" class="right-bar-toggle">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="{{ \Lib::get_gravatar(Auth::user()->email) }}"  alt="{{ Auth::user()->email }}" title="{{ Auth::user()->fullname }}">
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->fullname }}</span>
                        <span class="user-role">{{ Auth::user()->username }}</span>
                        <span class="user-status"><i class="fa fa-circle"></i><span>Online</span></span>
                    </div>
                </div>
                {{--<!-- sidebar-header  -->
                <div class="sidebar-search">
                    <div>
                        <div class="input-group">
                            <input type="text" class="form-control search-menu" placeholder="Search...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sidebar-search  -->--}}
                @if(!empty($menuLeft))
                    <div class="sidebar-menu">
                        <ul>
                            @foreach ($menuLeft as $menu)
                                @php($show=false)
                                @if(!empty($menu['perm']))
                                    @can($menu['perm'], $menu['perm'])
                                        @php($show=true)
                                    @endcan
                                @else
                                    @php($show=true)
                                @endif
                                @if($show)
                                    <li class="header-menu">
                                        <span>{{ $menu['title'] }}</span>
                                    </li>
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
                                                @if(!empty($sub['sub']))
                                                    <li class="sidebar-dropdown">
                                                        <a href="javascript:void(0)">
                                                            @if (!empty($sub['icon'])) <i class="{{ $sub['icon'] }}"></i> @endif
                                                            <span>{{ $sub['title'] }}</span>
                                                            @if($loop->first) <span class="badge badge-pill badge-success">Top 1</span> @endif
                                                        </a>
                                                        <div class="sidebar-submenu">
                                                            <ul>
                                                                @foreach ($sub['sub'] as $sub2)
                                                                    @php($show=false)
                                                                    @if(!empty($sub2['perm']))
                                                                        @can($sub2['perm'], $sub2['perm'])
                                                                            @php($show=true)
                                                                        @endcan
                                                                    @else
                                                                        @php($show=true)
                                                                    @endif
                                                                    @if($show)
                                                                        <li>
                                                                            <a href="{{ $sub2['link']!='' ? $sub2['link'] : 'javascript:void(0)' }}" @if($sub2['link']!='' && $sub2['newtab'] == 1) target="_blank"@endif>
                                                                                @if (!empty($sub2['icon'])) <i class="{{ $sub2['icon'] }}"></i> @endif {{ $sub2['title'] }}
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="{{ $sub['link']!='' ? $sub['link'] : 'javascript:void(0)' }}" @if($sub['link']!='' && $sub['newtab'] == 1) target="_blank" @endif>
                                                            @if (!empty($sub['icon'])) <i class="{{ $sub['icon'] }}"></i> @endif
                                                            <span>{{ $sub['title'] }}</span>
                                                            <span class="badge badge-pill badge-primary"></span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif

                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <!-- sidebar-menu  -->
                @endif
            </div>
            <!-- sidebar-content  -->
            <div class="sidebar-footer">
                {{--<a href="#">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-pill badge-warning notification">3</span>
                </a>
                <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span class="badge badge-pill badge-success notification">7</span>
                </a>
                <a href="#" class="">
                    <i class="fa fa-cog"></i>
                    <span class="badge-sonar"></span>
                </a>--}}
                <a href="{{ route('logout') }}" onclick="return confirm('Bạn có chắc chắn muốn thoát khỏi phiên đăng nhập?')" class="text-danger">
                    <i class="fa fa-power-off"></i>
                </a>
            </div>
        </nav>
    </div>
</div>
<!-- /Right-bar -->
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>