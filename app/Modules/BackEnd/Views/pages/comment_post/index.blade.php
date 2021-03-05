

@extends('BackEnd::layouts.default')
@section('CONTENT_REGION')
    <section id="table-chechbox">
        <div class="card card-accent-info">
            <div class="card-header">
                <!-- head -->
                <h5 class="card-title">
                    Danh sách {{ @$site_title }}
                    {{-- <span>
                        <a href="{{ route('admin.'.$key.'.add.post') }}" class="btn btn-info fix-add-btn" data-overlaycolor="#38414a">
                             Thêm mới
                        </a>
                    </span> --}}
                </h5>
                <!-- Single Date Picker and button -->
                <form id="search">
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo thương hiệu">
                                    <select id="table_id" name="table" class="form-control" data-toggle="select2">
                                        <option value=""> Chọn mục bình luận</option>
                                        <option value="products" {{ $search_data->table == 'products' ? 'selected="selected"' : '' }}>Sản phẩm</option>
                                        <option value="news" {{ $search_data->table == 'news' ? 'selected="selected"' : '' }}>Tin tức</option>
                                        <option value="service" {{ $search_data->table == 'service' ? 'selected="selected"' : '' }}>Dịch vụ</option>
                                        <option value="tuvan" {{ $search_data->table == 'tuvan' ? 'selected="selected"' : '' }}>Tư vấn</option>
                                        <option value="contact" {{ $search_data->table == 'contact' ? 'selected="selected"' : '' }}>Liên hệ</option>
                                        <option value="video" {{ $search_data->table == 'video' ? 'selected="selected"' : '' }}>Video</option>
                                    </select>
                                </fieldset>
                            </li>

                            <li>
                                <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo ngày khởi tạo">
                                    <input style="width: 200px;" autocomplete="off" type="text" name="time_between" value="{{ $search_data->time_between }}" class="form-control range-datepicker" placeholder="Chọn ngày khởi tạo"/>
                                    <div class="form-control-position">
                                        <i class="bx bx-calendar font-medium-1"></i>
                                    </div>
                                </fieldset>
                            </li>
                            {{-- <li>
                                <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm tên bản ghi">
                                    <input type="text" name="title" value="{{$search_data->title}}" class="form-control" />
                                    <div class="form-control-position">
                                        <i class="bx bxl-amazon font-medium-1"></i>
                                    </div>
                                </fieldset>
                            </li> --}}

                            

                        </ul>
                    </div>
                </form>
            </div>
            @if(empty($data))
                <div class="alert alert-danger" role="alert">
                    <i class="mdi mdi-block-helper mr-2"></i>
                    Không tìm thấy dữ liệu nào ở trang này. (Hãy kiểm tra lại các điều kiện tìm kiếm hoặc phân trang...)
                </div>
            @else
                <div class="table-responsive">
                    <div class="d-none" id="popup-action">
                        <div class="show">
                            <a href="javascript:void(0)" class="btn btn-danger mb-3 text-light mt-2 ml-2" onclick="shop.admin.checkAllAction('comment_post', 'status', -1)" title="Xóa tất cả bản ghi đã chọn">Xóa</a>
                        </div>
                    </div>
                    <table class="table table-centered table-bordered table-hover table table-transparent" id="table-extended-chechbox">
                        <thead>
                        <tr>
                            <th width="20" class="text-center">
                                <label><input type="checkbox"  class="checkbox-all-item-input custome-checkbox"><span></span></label>
                            </th>
                            {{-- <th width="55">Sort</th> --}}
                            <th>Tên người bình luận</th>
                            <th>URL</th>
                            <th>Loại bình luận</th>
                            <th width="55" align="center">Trạng thái</th>
                            <th width="100">Ngày tạo</th>
                            @php($cols = 9)
                            @if(\Lib::can($permission, 'edit'))
                                <th width="55">Tùy chọn</th>
                                @php($cols++)
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            @include('BackEnd::pages.comment_post.list-table', [
                            'd' => $item,
                            'sort_col' => 1,
                            'title_col' => 4,
                            'class' => 'alert-success'
                            ])
                            
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $data->links('BackEnd::layouts.pagin', ['data' => $data]) !!}
            @endif
        </div>
    </section>
@stop

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

