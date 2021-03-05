@extends('BackEnd::auth.layout')

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop
@section('CONTENT_REGION')
    <!-- register section starts -->
    <section class="row flexbox-container">
        <div class="col-xl-8 col-10">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">
                    <!-- register section left -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="text-center mb-2">Đăng ký</h4>
                                </div>
                            </div>
                            <div class="text-center">

                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {!! Form::open(['url' => route('register')]) !!}
                                        <div class="form-row">
                                            <div class="form-group col-md-6 mb-50">
                                                <label for="inputfirstname4">first name</label>
                                                <input type="text" class="form-control" autofocus id="inputfirstname4"
                                                       placeholder="First name">
                                            </div>
                                            <div class="form-group col-md-6 mb-50">
                                                <label for="inputlastname4">last name</label>
                                                <input type="text" class="form-control" id="inputlastname4"
                                                       placeholder="Last name">
                                            </div>
                                        </div>
                                        <div class="form-group mb-50">
                                            <label class="text-bold-600" for="user_name">Tên đăng nhập</label>
                                            <input type="text" class="form-control" id="user_name" name="user_name" autocomplete="off" value="{{ old('user_name') }}" required
                                                   placeholder="Tên đăng nhập của bạn"></div>
                                        <div class="form-group mb-50">
                                            <label class="text-bold-600" for="email">Email</label>
                                            <input type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required
                                                   placeholder="Địa chỉ email của bạn"></div>
                                        <div class="form-group mb-50">
                                            <label class="text-bold-600" for="password">Mật khẩu</label>
                                            <input type="password" class="form-control" required autocomplete="off" name="password" id="password"
                                                   placeholder="Nhập mật khẩu của bạn"></div>
                                        <div class="form-group mb-2">
                                            <label class="text-bold-600" for="password_confirmation">Xác nhận mật khẩu</label>
                                            <input type="password" class="form-control" required autocomplete="off" id="password_confirmation" name="password_confirmation"
                                                   placeholder="Xác nhận mật khẩu của bạn"></div>
                                        <button type="submit" class="btn btn-primary glow position-relative w-100">Đăng ký<i
                                                    id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                    {!! Form::close() !!}
                                    <hr>
                                    <div class="text-center"><small class="mr-25">Bạn là thành viên quản trị của {{ env('APP_NAME') }}?</small><a
                                                href="{{ route('login') }}"><small>Đăng nhập</small> </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- image section right -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <img class="img-fluid" src="{{ admin_link('frest-admin/app-assets/images/pages/register.png') }}" alt="branding logo">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- register section endss -->
@stop