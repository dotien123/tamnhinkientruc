@extends('BackEnd::layouts.default')
@section('BREADCRUMB_REGION')@stop
@section('CONTENT_REGION')

    <section id="auth-button"></section>
    <section id="view-selector"></section>
    <section id="timeline"></section>
    <!-- BEGIN: Content-->
    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">
        <div class="row">
            <!-- Greetings Content Starts -->
            <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
                <div class="card">
                    <div class="card-header">
                        <h3 class="greeting-text">Xin chào!</h3>
                        <p class="mb-0">Chào bạn bây giờ là  {{ date('H:s - d/m/Y') }}</p>
                    </div>
                    {{-- <div class="card-content">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="dashboard-content-left">
                                    <h1 class="text-primary font-large-2 text-bold-500">{{ @$todayTotalRevenue }}</h1>
                                    <p>Doanh số trong ngày hôm nay.</p>
                                </div>
                                <div class="dashboard-content-right">
                                    <img src="{{ admin_link('frest-admin/app-assets/images/icon/cup.png') }}"
                                         height="220" width="220"
                                         class="img-fluid"
                                         alt="{{ env('APP_NAME') }}"/>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!-- Multi Radial Chart Starts -->
            <div class="col-xl-4 col-12 dashboard-users">
                <div class="row  ">
                    <!-- Statistics Cards Starts -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-6 col-12 dashboard-users-success">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                                <i class="bx bx-briefcase-alt font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Tổng số sản phẩm</div>
                                            <h3 class="mb-0">{{ @$totalProduct?:0 }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6 col-12 dashboard-users-danger">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body py-1">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                <i class="bx bx-user font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">Số đơn hàng mới trong ngày</div>
                                            <h3 class="mb-0">{{ @$todayOrder?:0 }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-xl-12 col-lg-6 col-12 dashboard-revenue-growth">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center pb-0">
                                        <h4 class="card-title">Revenue Growth</h4>
                                        <div class="d-flex align-items-end justify-content-end">
                                            <span class="mr-25">$25,980</span>
                                            <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body pb-0">
                                            <div id="revenue-growth-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <!-- Revenue Growth Chart Starts -->
                </div>
            </div>
        </div>
        {{--<div class="row">
            <div class="col-xl-12 col-12 dashboard-marketing-campaign">
                <div class="card marketing-campaigns">
                    <div class="card-header d-flex justify-content-between align-items-center pb-1">
                        <h4 class="card-title">Danh sách sản phẩm được ưa chuộng nhiều nhất</h4>
                        <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                    <div class="card-content">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-9 col-12">
                                    <div class="d-inline-block">
                                        <!-- chart-1   -->
                                        <div class="d-flex market-statistics-1">
                                            <!-- chart-statistics-1 -->
                                            <div id="donut-success-chart"></div>
                                            <!-- data -->
                                            <div class="statistics-data my-auto">
                                                <div class="statistics">
                                                    <span class="font-medium-2 mr-50 text-bold-600">25,756</span><span
                                                            class="text-success">(+16.2%)</span>
                                                </div>
                                                <div class="statistics-date">
                                                    <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                    <small class="text-muted">May 12, 2019</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-inline-block">
                                        <!-- chart-2 -->
                                        <div class="d-flex mb-75 market-statistics-2">
                                            <!-- chart statistics-2 -->
                                            <div id="donut-danger-chart"></div>
                                            <!-- data-2 -->
                                            <div class="statistics-data my-auto">
                                                <div class="statistics">
                                                    <span class="font-medium-2 mr-50 text-bold-600">5,352</span><span
                                                            class="text-danger">(-4.9%)</span>
                                                </div>
                                                <div class="statistics-date">
                                                    <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                    <small class="text-muted">Jul 26, 2019</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 text-md-right">
                                    <button class="btn btn-sm btn-primary glow mt-md-2 mb-1">View Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- table start -->
                        <table id="table-marketing-campaigns"
                               class="table table-borderless table-marketing-campaigns mb-0">
                            <thead>
                            <tr>
                                <th>Campaign</th>
                                <th>Growth</th>
                                <th>Charges</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="py-1 line-ellipsis">
                                    <img class="rounded-circle mr-1"
                                         src="{{ admin_link('frest-admin/app-assets/images/icon/fs.png') }}"
                                         alt="card" height="24"
                                         width="24">Fastrack Watches
                                </td>
                                <td class="py-1">
                                    <i class="bx bx-trending-up text-success align-middle mr-50"></i><span>30%</span>
                                </td>
                                <td class="py-1">$5,536</td>
                                <td class="text-success py-1">Active</td>
                                <td class="text-center py-1">
                                    <div class="dropdown">
                    <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-edit-alt mr-1"></i> edit</a>
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-trash mr-1"></i>
                                                delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 line-ellipsis">
                                    <img class="rounded-circle mr-1"
                                         src="{{ admin_link('frest-admin/app-assets/images/icon/puma.png') }}"
                                         alt="card" height="24"
                                         width="24">Puma Shoes
                                </td>
                                <td class="py-1">
                                    <i class="bx bx-trending-down text-danger align-middle mr-50"></i><span>15.5%</span>
                                </td>
                                <td class="py-1">$1,569</td>
                                <td class="text-success py-1">Active</td>
                                <td class="text-center py-1">
                                    <div class="dropdown">
                    <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                    </span>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-edit-alt mr-1"></i> edit</a>
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-trash mr-1"></i>
                                                delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 line-ellipsis">
                                    <img class="rounded-circle mr-1"
                                         src="{{ admin_link('frest-admin/app-assets/images/icon/nike.png') }}"
                                         alt="card" height="24"
                                         width="24">Nike Air Jordan
                                </td>
                                <td class="py-1">
                                    <i class="bx bx-trending-up text-success align-middle mr-50"></i><span>70.30%</span>
                                </td>
                                <td class="py-1">$23,859</td>
                                <td class="text-danger py-1">Closed</td>
                                <td class="text-center py-1">
                                    <div class="dropdown">
                    <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                    </span>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-edit-alt mr-1"></i> edit</a>
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-trash mr-1"></i>
                                                delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 line-ellipsis">
                                    <img class="rounded-circle mr-1"
                                         src="{{ admin_link('frest-admin/app-assets/images/icon/one-plus.png') }}"
                                         alt="card"
                                         height="24" width="24">Oneplus 7 pro
                                </td>
                                <td class="py-1">
                                    <i class="bx bx-trending-up text-success align-middle mr-50"></i><span>10.4%</span>
                                </td>
                                <td class="py-1">$9,523</td>
                                <td class="text-success py-1">Active</td>
                                <td class="text-center py-1">
                                    <div class="dropdown">
                    <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                    </span>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-edit-alt mr-1"></i> edit</a>
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-trash mr-1"></i>
                                                delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 line-ellipsis">
                                    <img class="rounded-circle mr-1"
                                         src="{{ admin_link('frest-admin/app-assets/images/icon/google.png') }}"
                                         alt="card"
                                         height="24" width="24">Google Pixel 4 xl
                                </td>
                                <td class="py-1"><i
                                            class="bx bx-trending-down text-danger align-middle mr-50"></i><span>-62.38%</span>
                                </td>
                                <td class="py-1">12,897</td>
                                <td class="text-danger py-1">Closed</td>
                                <td class="text-center py-1">
                                    <div class="dropup">
                    <span
                            class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                    </span>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-edit-alt mr-1"></i> edit</a>
                                            <a class="dropdown-item" href="#"><i
                                                        class="bx bx-trash mr-1"></i>
                                                delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- table ends -->
                    </div>
                </div>
            </div>
        </div>--}}
    </section>
    <!-- Dashboard Ecommerce ends -->
    <!-- END: Content-->
@stop

@section('CSS_REGION')

    {!! \Lib::addMedia('admin/frest-admin/app-assets/css/pages/dashboard-ecommerce.min.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/charts/apexcharts.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/extensions/swiper.min.css') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/daterangepicker.css') !!}
@stop

@push('JS_PLUGINS_REGION')
    <script>
        (function(w,d,s,g,js,fjs){
            g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
            js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
            js.src='https://apis.google.com/js/platform.js';
            fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
        }(window,document,'script'));
    </script>
    <script>
        gapi.analytics.ready(function() {

            // Step 3: Authorize the user.

            var CLIENT_ID = 'Insert your client ID here';

            gapi.analytics.auth.authorize({
                container: 'auth-button',
                clientid: CLIENT_ID,
            });

            // Step 4: Create the view selector.

            var viewSelector = new gapi.analytics.ViewSelector({
                container: 'view-selector'
            });

            // Step 5: Create the timeline chart.

            var timeline = new gapi.analytics.googleCharts.DataChart({
                reportType: 'ga',
                query: {
                    'dimensions': 'ga:date',
                    'metrics': 'ga:sessions',
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday',
                },
                chart: {
                    type: 'LINE',
                    container: 'timeline'
                }
            });

            // Step 6: Hook up the components to work together.

            gapi.analytics.auth.on('success', function(response) {
                viewSelector.execute();
            });

            viewSelector.on('change', function(ids) {
                var newIds = {
                    query: {
                        ids: ids
                    }
                }
                timeline.set(newIds).execute();
            });
        });
    </script>
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/ui/jquery.sticky.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/charts/apexcharts.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/extensions/swiper.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/js/scripts/pages/dashboard-ecommerce.min.js') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/moment.min.js') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/daterangepicker.js') !!}
    <script>
        $(document).ready(function () {
            jQuery(".range-datepicker").daterangepicker({
                autoUpdateInput: false,
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    format: 'DD/MM/YYYY hh:mm A',
                    cancelLabel: 'Clear',
                }

            });
            $('.range-datepicker').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY hh:mm A') + ' - ' + picker.endDate.format('DD/MM/YYYY hh:mm A'));
            });
            $('.range-datepicker').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });

        function SHOW_POPUP(id, type) {
            shop.ajax_popup(type + '/popup-preview', 'POST', {
                    id: id
                }, function (response) {
                    if (response.error == 1) {
                        Swal.fire({
                            title: 'Oops!',
                            text: response.msg,
                            type: "warning",
                            showCancelButton: !0,
                            showConfirmButton: 0,
                            cancelButtonColor: "#d33",
                            cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                            buttonsStyling: !1,
                        });

                    } else {
                        $('.preview').empty().html(response);
                        $('.bs-example-modal-center').modal({backdrop: 'static'});
                        $('.switchery-popup').each(function (idx, obj) {
                            new Switchery($(this)[0], $(this).data());
                        });
                    }
                },
                'html'
            );
        }
    </script>
@endpush