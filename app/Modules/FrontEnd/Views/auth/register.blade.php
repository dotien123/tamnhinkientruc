@extends('FrontEnd::layouts.home')
@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop
@section('content')
    <div class="form-user pt-5">
        <div class="container">
            <form id="form-register" method="post">
            @csrf
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
@stop