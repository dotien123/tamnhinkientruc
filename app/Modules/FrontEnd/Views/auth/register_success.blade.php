@extends('FrontEnd::layouts.default')

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop

@section('content')
<div id="content" class="section content-wrap content-info">
    <div class="container clearfix">
        <div class="travel-info-wrap">
            <div class="fs-14 fc-black" align="center">
                <h1 class="">Đăng kí tài khoản thành công</h1>
                <p>Chào mừng bạn đến với <span class="fw-ob">{{ env('APP_NAME') }}</span></p>
                <p>Bạn vui lòng <a class="bg-primary p-1 text-white" href="{{ route('login') }}">đăng nhập</a> để tiếp tục</p>
            </div>
        </div>
    </div>
</div>
@stop