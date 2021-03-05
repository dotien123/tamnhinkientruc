@extends('BackEnd::auth.layout')

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop
@section('CONTENT_REGION')
    <!-- login page start -->
    <section id="auth-login" class="row flexbox-container">
        <div class="col-xl-8 col-11">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">
                    <!-- left section-login -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="text-center mb-2">Welcome {{ env('APP_NAME') }}</h4>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    {!! Form::open(['url' => route('login')]) !!}
                                        <div class="form-group mb-50">
                                            <label class="text-bold-600" for="user_name">Tài khoản đăng nhập</label>
                                            <input class="form-control" type="text" id="user_name" name="user_name" autocomplete="off" value="{{ old('user_name') }}" required autofocus
                                                   placeholder="Nhập tài khoản của bạn"></div>
                                        <div class="form-group">
                                            <label class="text-bold-600" for="password">Mật khẩu</label>
                                            <input type="password" class="form-control" required autocomplete="off" name="password" id="password"
                                                   placeholder="Nhập mật khẩu của bạn">
                                        </div>
                                        <div
                                                class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                            <div class="text-left">
                                                <div class="checkbox checkbox-sm">
                                                    <input type="checkbox" class="form-check-input" id="remember_pass" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="checkboxsmall" for="remember_pass"><small>Ghi nhớ</small></label>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <a href="{{ route('password.request') }}" class="card-link"><small>Quên mật khẩu?</small></a>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary glow w-100 position-relative">Đăng nhập<i
                                                    id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                    {!! Form::close() !!}
                                    <hr>
                                    <div class="text-center"><small class="mr-25">Bạn không phải là thành viên của {{ env('APP_NAME') }}?</small><a
                                                href="{{ route('register') }}"><small>Đăng ký</small></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- right section image -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <div class="card-content">
                            <img class="img-fluid" src="{{ admin_link('frest-admin/app-assets/images/pages/login.png') }}" alt="branding logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
