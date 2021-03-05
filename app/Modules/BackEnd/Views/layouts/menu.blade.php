<!-- BEGIN: Main Menu-->
<div class="menu-fck header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow" role="navigation" data-menu="menu-wrapper">
    <div class="navbar-header d-xl-none d-block">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="index.html">
                    <div class="brand-logo"><img class="logo" src="{{ admin_link('frest-admin/app-assets/images/logo/logo.png') }}"/></div>
                    <h2 class="brand-text mb-0">CMS Kayn</h2></a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <!-- Horizontal menu content-->
    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <!-- include ../../../includes/mixins-->
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="filled">
            @foreach ($menuLeft as $k => $menu)
                @if($k == '_72')
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
                                    @if(!empty($sub['sub']))
                                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                                                <i class="menu-livicon" data-icon="brush"></i><span>{{ $sub['title'] }}</span></a>
                                            <ul class="dropdown-menu">
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
                                                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
                                                            <a class="dropdown-item align-items-center {{ (!empty($sub2['sub'])) ? 'dropdown-toggle' : '' }}" href="{{ $sub2['link']!='' ? $sub2['link'] : 'javascript:void(0)' }}"
                                                               @if($sub2['link']!='' && $sub2['newtab'] == 1) target="_blank"@endif data-toggle="dropdown">
                                                                <i class='bx bx-right-arrow-alt'></i>{{ $sub2['title'] }}
                                                            </a>
                                                            @if(!empty($sub2['sub']))
                                                            <ul class="dropdown-menu">
                                                                <li data-menu=""><a class="dropdown-item align-items-center" href="app-invoice-list.html" data-toggle="dropdown"><i class='bx bx-right-arrow-alt'></i>Invoice List</a>
                                                                </li>
                                                                <li data-menu=""><a class="dropdown-item align-items-center" href="app-invoice.html" data-toggle="dropdown"><i class='bx bx-right-arrow-alt'></i>Invoice</a>
                                                                </li>
                                                                <li data-menu=""><a class="dropdown-item align-items-center" href="app-invoice-edit.html" data-toggle="dropdown"><i class='bx bx-right-arrow-alt'></i>Invoice Edit</a>
                                                                </li>
                                                                <li data-menu=""><a class="dropdown-item align-items-center" href="app-invoice-add.html" data-toggle="dropdown"><i class='bx bx-right-arrow-alt'></i>Invoice Add</a>
                                                                </li>
                                                            </ul>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a class="dropdown-toggle nav-link" href="{{ $sub['link']!='' ? $sub['link'] : 'javascript:void(0)' }}"@if($sub['link']!='' && $sub['newtab'] == 1) target="_blank"@endif>
                                                <i class="menu-livicon" data-icon="comments"></i><span>{{ $sub['title'] }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                            <li class="divider"></li>
                        @endif
                    @endif
                @endif
            @endforeach


        </ul>
    </div>
    <!-- /horizontal menu content-->
</div>
<!-- END: Main Menu-->


