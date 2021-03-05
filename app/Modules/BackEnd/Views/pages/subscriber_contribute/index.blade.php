@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
<section id="table-chechbox">
    <div class="card">
        <div class="card-header">
            <!-- head -->
            <h5 class="card-title">
                Danh sách {{ @$site_title }}
              
            </h5>
            <form id="search">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-12 col">
                            {!! Form::open(['url' => route('admin.'.$key), 'method' => 'get', 'id' => 'search']) !!}
                            <div class="row">
                                <div class="form-group col-sm-2">
                                    <div class="input-group">
                                        <input type="text" name="phone" class="form-control" placeholder="Điện thoại" value="{{$search_data->phone}}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo ngày khởi tạo">
                                        <input style="" autocomplete="off" type="text" name="time_between" value="{{ $search_data->time_between }}" class="form-control range-datepicker" placeholder="Chọn ngày khởi tạo"/>
                                        <div class="form-control-position">
                                            <i class="bx bx-calendar font-medium-1"></i>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="form-group col-sm-4">
                                    <div class="input-group">
                                        <input type="text" name="fullname" class="form-control" placeholder="Họ và tên" value="{{$search_data->fullname}}">
                                        
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    @if(empty($data) || $data->isEmpty())
                        <div class="alert alert-danger" role="alert">
                            <i class="mdi mdi-block-helper mr-2"></i>
                            Không tìm thấy dữ liệu nào ở trang này. (Hãy kiểm tra lại các điều kiện tìm kiếm hoặc phân trang...)
                        </div>
                    @else
                    @include('BackEnd::pages.subscriber_contribute.include.list-table')
                        {!! $data->links('BackEnd::layouts.pagin', ['data' => $data]) !!}
                    @endif
                </div>
            </div>
            </form>
        </div>
    </div>
            <!--- end row -->
@stop
@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.css') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/daterangepicker.css') !!}

@stop

@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/select2/select2.min.js') !!}
    {!! \Lib::addMedia('admin/js/form-pickers.init.js') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/moment.min.js') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/daterangepicker.js') !!}

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
                shop.admin.updateStatus('filter', $ele.data('id'), $ele.prop("checked"))
            })
        });

    </script>
    <script>
        $(document).ready(function() {
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
        });
    </script>
@endpush