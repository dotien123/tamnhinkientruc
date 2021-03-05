@extends('FrontEnd::layouts.home')

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop

@section('content')
    <div class="wrapper">
        <div id="formContent">
            <!-- Tabs Titles -->
            <ul class="nav nav-tabs" style="padding-left: 0 !important;" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active tab-login" style="" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                        <i class="fa fa-user-secret"></i> Đăng nhập
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-reg" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                        <i class="fa fa-user-plus"></i> Đăng ký</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <!-- Icon -->
                    <div>
                        <img width="168" src="{{ asset('html/images/login-icon.svg') }}" class="icon" alt="Đăng nhập, đăng ký"/>
                    </div>
                    <!-- Login Form -->
                        {!! Form::open(['id' => 'formLogin' , 'method' => 'post']) !!}
                        <input type="email"  class="input-text" name="userOrEmail" placeholder="Tài khoản hoặc Email...">
                        <input type="password" class="input-text"  id="password" name="password" placeholder="Mật khẩu...">
                        <div class="form-group mb-3">
                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="remember_pass" name="remember" {{ old('remember') ? 'checked' : '' }} class="custom-control-input">
                                    <label class="custom-control-label" for="remember_pass">Remember me</label>
                                </div>
                            </div>
                        </div>
                        <input type="button" onclick="return Member.doLogin('#formLogin')" class="mt-3" value="Đăng nhập">
                        {!! Form::close() !!}

                    <div class="article-social">
                        <div class="login-social-icons">
                            <ul>
                                <li class="login-fb"><img src="{{ asset('html/images/facebook.svg') }}" alt="Đăng nhập bằng Facebook"><a href="{{route('facebook.login')}}" rel="nofollow"> Đăng nhập bằng Facebook</a></li>
                                <li class="login-gp"><img src="{{ asset('html/images/google-plus.svg') }}" alt="Đăng nhập bằng Google"><a href="{{route('google.login')}}" rel="nofollow"> Đăng nhập bằng Google</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <!-- Icon -->
                    <div>
                        <img width="168"  src="{{ asset('html/images/login-icon.svg') }}" class="icon" alt="Đăng nhập, đăng ký"/>
                    </div>

                    <!-- Login Form -->
                    <form class="mt-3" id="form-register" method="post" >
                        <div class="title-heading">Rigister</div>
                        <div class="validate-input">
                            <label for="name">User name</label>
                            <input class="has-icon icon-lock" id="pop-username" type="text" name="user_name" placeholder="Nhập usename" required>
                        </div>
                        <div class="validate-input">
                            <label for="name">Email:</label>
                            <input class="has-icon icon-user" type="email" id="pop-email" name="email"
                                   placeholder="Địa chỉ Email" required>
                        </div>
                        <div class="validate-input">
                            <label for="name">Mật khẩu:</label>
                            <input class="has-icon icon-lock" id="pop-pw" type="password" name="password" placeholder="Mật khẩu:" required>
                        </div>
                        <div class="validate-input">
                            <label for="name">Xác nhận mật khẩu:</label>
                            <input class="has-icon icon-lock" id="pop-pw-rp" type="password" name="re-pwd" placeholder="Xác nhận mật khẩu" required>
                        </div>
                        <div class="validate-input">
                            <label for="name">Ho va ten</label>
                            <input class="has-icon icon-lock" id="pop-fullname" type="text" name="fullname" placeholder="Họ và tên" required>
                        </div>
                        <div class="validate-input">
                            <label for="name">Số điện thoại</label>
                            <input class="has-icon icon-lock" id="pop-phone" type="text" name="phone" placeholder="Số điện thoại" required>
                        </div>
                        <div class="submit">
                            <div class="submit">
                                <button type="button" onclick="shop.register()" class="btn-send">Đăng ký</button>
                            </div>
                            <div class="creat-acc">Bạn đã có tài khoản: <a href="{{ route('login') }}" class="link-register">Đăng nhập</a></div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="{{route('password')}}">Quên mật khẩu?</a>
            </div>

        </div>
    </div>
@stop