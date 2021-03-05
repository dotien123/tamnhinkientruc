@extends('BackEnd::auth.layout')

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop
@section('CONTENT_REGION')
    <!-- forgot password start -->
    <section class="row flexbox-container">
        <div class="col-xl-7 col-md-9 col-10  px-0">
            <div class="card bg-authentication mb-0">
                @if( count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{!! $error !!}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="row m-0">
                    <!-- left section-forgot password -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right mb-0 p-2">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="text-center mb-2">Quên mật khẩu?</h4>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-between align-items-center mb-2">
                                <div class="text-left">
                                    <div class="ml-3 ml-md-2 mr-1"><a href="{{ route('login') }}"
                                                                      class="card-link btn btn-outline-primary text-nowrap">Đăng nhập</a></div>
                                </div>
                                <div class="mr-3"><a href="{{ route('register') }}"
                                                     class="card-link btn btn-outline-primary text-nowrap">Đăng ký</a></div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="text-muted text-center mb-2"><small>Nhập email bạn đã sử dụng khi tham gia và chúng tôi sẽ gửi cho bạn mật khẩu tạm thời</small></div>
                                    {!! Form::open(['url' => route('password.email')]) !!}
                                    <div class="form-group mb-2">
                                        <label class="text-bold-600" for="exampleInputEmailPhone1">Email</label>
                                        <input type="email" autofocus class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" required
                                               placeholder="Địa chỉ email của bạn"></div>
                                    <button type="submit" class="btn btn-primary glow position-relative w-100">Gửi link lấy lại mật khẩu<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                    {!! Form::close() !!}
                                    <div class="text-center mb-2"><a href="{{ route('login') }}"><small class="text-muted">Tôi nhớ mật khẩu của mình</small></a></div>
                                    <div class="divider mb-2">
                                        <div class="divider-text"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- right section image -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center">
                        <img class="img-fluid" src="{{ admin_link('frest-admin/app-assets/images/pages/forgot-password.png') }}"
                             alt="branding logo" width="300">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- forgot password ends -->
@endsection
