@extends('FrontEnd::layouts.default')

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop

@section('content')
<div id="content" class="section content-wrap content-login mb-4 py-4">
    <div class="container clearfix">
        <div class="login-wrapper">
            <center>
                <p>Vui lòng liên hệ với <a href="{{env('URL_FACEBOOK')}}">admin</a> để viết bài</p>
                <h2 style="line-height: 45px;">
                    <span class="label bg-success">Khách quan</span>
                    <span class="label bg-info">Đầy đủ</span>
                    <span class="label bg-primary">Chính xác</span>
                </h2>
                <p class="lead"><a href="/top-list/tieu-chi-ma-bai-viet-toplistvn-luon-huong-den-13037.htm">Là top <span class="text-warning">3</span> tiêu chí mà {{ env('APP_DOMAIN') }} luôn luôn hướng tới để đem lại những thông tin hữu ích nhất cho cộng đồng</a></p>
            </center>
        </div>
    </div>
</div>
@stop