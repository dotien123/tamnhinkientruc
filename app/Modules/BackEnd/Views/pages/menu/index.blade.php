@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
    <section id="table-chechbox">
        <div class="card card-accent-info">
            <div class="card-header">
                <!-- head -->
                <h5 class="card-title">
                    Danh sách {{ @$site_title }}
                    <span>
                        <a href="{{ route('admin.'.$key.'.add.post') }}" class="btn btn-info fix-add-btn" data-overlaycolor="#38414a">
                             Thêm mới
                        </a>
                    </span>
                </h5>
                <form id="search">
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo ngày khởi tạo">
                                    <input style="width: 200px;" autocomplete="off" type="text" name="time_between" value="{{ $search_data->time_between }}" class="form-control range-datepicker" placeholder="Chọn ngày khởi tạo"/>
                                    <div class="form-control-position">
                                        <i class="bx bx-calendar font-medium-1"></i>
                                    </div>
                                </fieldset>
                            </li>
                            <li>
                                <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm tên bản ghi">
                                    <input type="text" name="title" value="{{$search_data->title}}" class="form-control" />
                                    <div class="form-control-position">
                                        <i class="bx bxl-amazon font-medium-1"></i>
                                    </div>
                                </fieldset>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-centered table-bordered table-hover table table-transparent" id="table-extended-chechbox">
                    <thead>
                    <tr>
                        <th width="55">Sort</th>
                        <th width="65">Cấp 1</th>
                        <th width="65">Cấp 2</th>
                        <th width="65">Cấp 3</th>
                        <th>Tiêu đề</th>
                        <th>Link</th>
                        <th>Trạng thái</th>
                        {{-- <th>NewTab</th>
                        <th>Follow</th> --}}
                        <th width="100">Ngày tạo</th>
                        @php($cols = 11)
                        @if(\Lib::can($permission, 'edit'))
                            @php($cols++)
                            <th width="55"></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $item)
                        <tr class="bg-teal-800">
                            <td colspan="{{$cols}}" class="text-uppercase text-bold-600 pl-0"><b>{{ $item['title'] }} - {{ $item['type'] }}</b></td>
                        </tr>
                        @foreach ($item['menus'] as $menu)
                            @include('BackEnd::pages.menu.list', [
                            'd' => $menu['data'],
                            'sort_col' => 1,
                            'title_col' => 4,
                            'class' => 'alert-success'
                            ])
                            @if(!empty($menu['sub']))
                                @foreach ($menu['sub'] as $sub1)
                                    @include('BackEnd::pages.menu.list', [
                                    'd' => $sub1['data'],
                                    'sort_col' => 2,
                                    'title_col' => 3,
                                    'class' => 'alert-warning'
                                    ])
                                    @if(!empty($sub1['sub']))
                                        @foreach ($sub1['sub'] as $sub2)
                                            @include('BackEnd::pages.menu.list', [
                                            'd' => $sub2,
                                            'sort_col' => 3,
                                            'title_col' => 2,
                                            'class' => 'text-danger'
                                            ])
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="preview"></div>
        </div>
    </section>
@endsection


@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/select2/select2.min.css') !!}
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.css') !!}
    {!! \Lib::addMedia('admin/libs/custombox/custombox.min.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/pickers/daterange/daterangepicker.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/tables/datatable/datatables.min.css') !!}
@stop

@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/libs/select2/select2.min.js') !!}
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.js') !!}
    {!! \Lib::addMedia('admin/libs/custombox/custombox.min.js') !!}
    {!! \Lib::addMedia('admin/libs/tippy-js/tippy.all.min.js') !!}
    {!! \Lib::addMedia('admin/js/form-pickers.init.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/picker.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/picker.date.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/picker.time.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/legacy.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/daterange/moment.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/daterange/daterangepicker.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tables/datatable/datatables.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') !!}
    <script>
        $(document).ready(function() {
            $('[data-plugin="switchery"]').each(function (idx, obj) {
                new Switchery($(this)[0], $(this).data());
            });
            $('[data-toggle="select2"]').select2();

            $("input.placement").maxlength({
                alwaysShow: !0,
                placement: "top-left",
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });
            $('.switchery').on('click', function() {
                let $ele = $(this).siblings('input[data-plugin="switchery"]');
                console.log($(this),$ele.data('id'), $ele.prop("checked"));
                shop.admin.updateStatus('menu', $ele.data('id'), $ele.prop("checked"))
            });

        });
        function SHOW_POPUP(id, bidx) {
            shop.ajax_popup('product/popup-preview', 'POST', {
                id: id,
                basic_pid: bidx
            }, function (json) {
                if (json.error == 0) {
                    $('.preview').empty().append(json.data);
                    $('.bs-example-modal-center').modal({backdrop: 'static'});
                    $('.switchery-popup').each(function (idx, obj) {
                        new Switchery($(this)[0], $(this).data());
                    });
                }else {
                    Swal.fire({
                        title: 'Oops!',
                        text: json.msg,
                        type: "warning",
                        showCancelButton: !0,
                        showConfirmButton: 0,
                        cancelButtonColor: "#d33",
                        cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                        buttonsStyling: !1,
                    });
                }
            });
        }
        $(".range-datepicker").daterangepicker({
            autoUpdateInput: false,
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            minYear: 1990,
            maxYear: parseInt(moment().format("YYYY"), 10),
            locale: {
                format: 'DD/MM/YYYY hh:mm A',
                cancelLabel: 'Xóa',
                applyLabel: 'Cập nhật',
            }

        });
        $('.range-datepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY hh:mm A') + ' - ' + picker.endDate.format('DD/MM/YYYY hh:mm A'));
            $('#search').trigger('submit');
        });
        $('.range-datepicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#search').trigger('submit');
        });
    </script>
@endpush