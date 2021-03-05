@extends('BackEnd::auth.layout')

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop
@section('CONTENT_REGION')
    <div class="card h-100">
        <div class="card-body">
            <div class="col-md-12">
                <div class="">
                    <h1 class="text-success">Đăng kí thành công</h1>
                    <p class="lead">Hiện tại bạn chưa thể đăng nhập do tài khoản chưa được kích hoạt</p>
                    <hr class="my-4">
                    <p>Nếu bạn có bất kì thắc mắc nào vui lòng liên hệ với quản trị viên</p>
                    <p class="lead">
                        <a class="btn btn-success btn-lg" href="mailto:lymanhha@gmail.com" role="button"><i class="mdi mdi-email-check"></i>&nbsp; Gửi email liên hệ</a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a class="btn btn-outline-success btn-lg" href="{{ route('login') }}" role="button"><i class="fa fa-mail-reply"></i>&nbsp; Về đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop