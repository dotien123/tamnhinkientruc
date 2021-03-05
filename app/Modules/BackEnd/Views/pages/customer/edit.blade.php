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
                                <li class="breadcrumb-item"><a href="{{route('admin.customer') }}">Danh sách khách hàng</a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-6">
                    {!! Form::open(['url' => route('admin.customer.edit.post', $data->id)]) !!}
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-user"></i>Sửa thông tin khách hàng <b>{{ $data->fullname }}</b>
                        </div>
                        <div class="card-body">
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

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullname">Họ và tên</label>
                                        <input type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" id="fullname" name="fullname" value="{{ old('fullname', $data->fullname) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email </label>
                                        <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email', $data->email) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại </label>
                                        <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone', $data->phone) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="password">Mật khẩu </label>
                                        <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="password_confirm">Nhập lại mật khẩu </label>
                                        <input type="password" class="form-control{{ $errors->has('password_confirm') ? ' is-invalid' : '' }}" id="password_confirm" name="password_confirm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fe-send"></i> Cập nhật</button>
                            <a class="btn btn-sm btn-danger" href="{{ redirect()->back()->getTargetUrl() }}"><i class="fa fa-ban"></i> Hủy bỏ</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop