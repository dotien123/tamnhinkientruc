@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Quản trị khách hàng</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12">
{{--                    <div class="mb-5"><h1>Quản trị {{ $site_title }}</h1></div>--}}
                    @if( count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{!! $error !!}</div>
                            @endforeach
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success">
                            {!! session('status') !!}
                        </div>
                    @endif
                    {!! Form::open(['url' => route('admin.'.$key), 'method' => 'get', 'id' => 'searchForm']) !!}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="mdi mdi-email-check"></i></span>
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{$search_data['email']}}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="mdi mdi-phone-classic"></i></span>
                                        <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="{{$search_data['phone']}}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="mdi mdi-calendar-clock"></i></span>
                                        <input type="text" name="time_from" id="basic-datepicker"
                                               class="datepicker form-control" placeholder="Từ ngày" autocomplete="off"
                                               value="{{ $search_data->time_from }}">
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="mdi mdi-calendar-clock"></i></span>
                                        <input type="text" name="time_to" id="basic-2-datepicker"
                                               class="datepicker form-control" placeholder="Đến ngày" autocomplete="off"
                                               value="{{ $search_data->time_to }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <div class="card card-accent-info">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Danh sách khách hàng
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th width="55">ID</th>
                                    <th width="110">Avatar</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số dư tài khoản</th>
                                    <th width="110">Điện thoại</th>
                                    <th width="200">Đăng kí</th>
                                    <th width="200">Đăng nhập</th>
                                    @if(\Lib::can($permission, 'edit'))
                                        <th width="55">Sửa</th>
                                    @endif
                                    @if(\Lib::can($permission, 'delete'))
                                        <th width="55">Xóa</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $customer)
                                    <tr>
                                        <td align="center">{{ $customer->id }}</td>
                                        <td align="center">
                                            @if(!empty($customer->avatar))
                                                <img src="{{ $customer->getImageUrl('small') }}" class="float-left" width="80">
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            {{ $customer->fullname }}
                                        </td>
                                        <td>
                                            {{ $customer->email }}
                                        </td>
                                        <td>
                                            {{ ($customer->money) ? \Lib::priceFormat($customer->money) : '0 đ'}}
                                        </td>
                                        <td align="center">{{ $customer->phone }}</td>
                                        <td>
                                            <div><b>IP:</b> {{ $customer->reg_ip }}</div>
                                            <div><b>Lúc:</b> {{ \Lib::dateFormat($customer->created, 'd/m/Y H:i:s') }}</div>
                                        </td>
                                        <td>
                                            <div><b>IP:</b> @if(!empty($customer->last_login_ip)) {{ $customer->last_login_ip }} @else --- @endif</div>
                                            <div><b>Lúc:</b> @if(!empty($customer->last_login)) {{ \Lib::dateFormat($customer->last_login, 'd/m/Y H:i:s') }} @else <span class="text-muted">Chưa đăng nhập</span> @endif</div>
                                        </td>
                                        @if(\Lib::can($permission, 'edit'))
                                            <td align="center"><a href="{{ route('admin.'.$key.'.edit', $customer->id) }}" class="text-primary"><i class="icon-pencil icons"></i></a></td>
                                        @endif
                                        @if(\Lib::can($permission, 'delete'))
                                            <td align="center"><a href="{{ route('admin.'.$key.'.delete', $customer->id) }}" class="text-danger" onclick="return confirm('Bạn muốn xóa ?')"><i class="icon-trash icons"></i></a></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @if(empty($data) || $data->isEmpty())
                                <h4 align="center">Không tìm thấy dữ liệu phù hợp</h4>
                            @else
                                <div class="pull-right">Tổng cộng: {{ $data->count() }} bản ghi / {{ $data->lastPage() }} trang</div>
                                {!! $data->links('BackEnd::layouts.pagin') !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.css') !!}
@stop

@section('js_bot')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/select2/select2.min.js') !!}
    {!! \Lib::addMedia('admin/js/form-pickers.init.js') !!}
@stop