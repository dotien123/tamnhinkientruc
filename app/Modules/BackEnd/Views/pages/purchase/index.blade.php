@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
<section id="table-chechbox">
            <div class="card">
                <div class="card-header">
                    <!-- head -->
                    <h5 class="card-title">
                        Danh sách {{ @$site_title }}
                      
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-lg-12 col">
                                    {!! Form::open(['url' => route('admin.'.$key), 'method' => 'get', 'id' => 'search']) !!}
                                    <div class="row">
                                        <div class="form-group col-sm-2">
                                            <div class="input-group">
                                                <input type="text" name="email" class="form-control" placeholder="Email" value="{{$search_data->email}}">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <div class="input-group">
                                                <input type="text" name="phone" class="form-control" placeholder="Điện thoại" value="{{$search_data->phone}}">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <div class="input-group w-100">
                                                <input title="Tìm theo khoảng thời gian người dùng đăng ký" data-plugin="tippy"
                                                       data-tippy-animation="scale" data-tippy-inertia="true"
                                                       data-tippy-duration="[600, 300]" data-tippy-arrow="true" autocomplete="off"
                                                       type="text" name="time_between" value="{{ $search_data->time_between }}"
                                                       class="form-control range-datepicker"
                                                       placeholder="Tìm theo khoảng thời gian người dùng đăng ký">
                                            </div>
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
                                @include('BackEnd::pages.purchase.include.list-table')
                                {!! $data->links('BackEnd::layouts.pagin', ['data' => $data]) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
                    <!--- end row -->
             
@stop
@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.css') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/daterangepicker.css') !!}
    {!! \Lib::addMedia('admin/libs/custombox/custombox.min.css') !!}
@stop

@push('JS_PLUGINS_REGION')
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