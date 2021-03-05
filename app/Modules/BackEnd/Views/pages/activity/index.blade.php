@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')


<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý hoạt động chính</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        {{--@include('views/include/sumary-basic')--}}

        <div class="row mt-2">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-3 col">
                                <a href="{{ route('admin.'.$key.'.add.post') }}"
                                   class="btn btn-danger waves-effect waves-light"
                                   data-overlaycolor="#38414a"><i class="mdi mdi-plus-circle mr-1"></i> Thêm bài viết mới</a>
                            </div>
                            <div class="mini-search-bar-right col-lg-9 col">
                                {!! Form::open(['url' => route('admin.'.$key), 'method' => 'get', 'id' => 'searchForm', 'class' => 'w-100']) !!}
                                <div class="row">
                                    <div class="form-group col">
                                        <div class="input-group">
                                            <select name="status" class="form-control" data-toggle="select2">
                                                <option value="">Chọn trạng thái </option>
                                                <option value="1"{{ $search_data->status == 1 ? ' selected="selected"' : '' }}>Đang hoạt động</option>
                                                <option value="0"{{ $search_data->status == '0' ? ' selected="selected"' : '' }}>Chưa hiển thị</option>
                                                <option value="-1"{{ $search_data->status == -1 ? ' selected="selected"' : '' }}>Đã xóa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <div class="input-group">
                                            <span title="Ngày khởi tạo" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true">
                                            <input type="text" name="time_from" class="datepicker form-control" id="basic-datepicker" placeholder="Ngày khởi tạo" autocomplete="off" value="{{ $search_data->time_from }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-8">
                                        <div class="input-group">
                                            <input type="text" name="title" class="form-control placement" maxlength="250" placeholder="Tên" value="{{$search_data->title}}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-teal-800"><i class="fa fa-search"></i> Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        @if(empty($lsObj) || $lsObj->isEmpty())
                            <div class="alert alert-danger" role="alert">
                                <i class="mdi mdi-block-helper mr-2"></i>
                                Không tìm thấy dữ liệu nào ở trang này. (Hãy kiểm tra lại các điều kiện tìm kiếm hoặc phân trang...)
                            </div>
                        @else
                            @include('BackEnd::pages.'.$key.'.include.list-table')
                            {!! $lsObj->links('BackEnd::layouts.pagin', ['data' => $lsObj]) !!}
                        @endif
                        
                    </div>

                </div>

                <!--- end row -->
            </div>
        </div>

    </div>
</div>
@endsection


@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.css') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.css') !!}
@stop

@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/tippy-js/tippy.all.min.js') !!}
    {!! \Lib::addMedia('admin/js/form-pickers.init.js') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.js') !!}

    <script>
         @if (session('status'))
            toastr.options.progressBar = true;
            toastr.info('{!! session('status') !!}');
        @endif
        @if( count($errors) > 0)
            toastr.options.progressBar = true;
            var err = '{!! json_encode($errors->all()) !!}';
            console.log(err);
            toastr.error(JSON.parse(err));
        @endif
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
                shop.admin.updateStatus('activity', $ele.data('id'), $ele.prop("checked"))
            })
        });
    </script>

@endpush
