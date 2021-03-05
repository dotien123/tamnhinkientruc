@extends('FrontEnd::layouts.home')

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop

@section('content')
    <div id="content" class="section content-wrap content-login">
        <div class="container clearfix">
            <div class="login-wrapper">
                <div class="clearfix">
                    <div class="login-l make-left">
                        <div class="login-form-title fw-rbm fs-22 fc-black">{{ __('auth.taomatkhaumoi') }}</div>
                        <div class="popup-olala-login">
                            <div class="popup-form">
                                @if( count($errors) > 0)
                                    <div class="row-err">
                                        @foreach ($errors->all() as $error)
                                            <div class="err-notice fs-14">{!! $error !!}</div>
                                        @endforeach
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
{{--                                {!! Form::open(['url' => route('profile.password.reset.post')]) !!}--}}

                                 {!! Form::open() !!}
                                 <br>
                                <div class="popup-form-row @if($errors->has('password')) popup-form-row-err @endif ">
                                    <div class="">
                                        <label for="pop-pw-form">Mật khẩu cũ<i class="icons iLock"></i></label>
                                        <div class="feedback"></div>
                                        <input id="current_password" class="pop-input" type="password" placeholder="Mật khẩu cũ" name="password_old" required>
                                    </div>
                                 </div>
                                <div class="popup-form-row @if($errors->has('password')) popup-form-row-err @endif">
                                    <label for="pop-pw-form">Mật khẩu mới<i class="icons iLock"></i></label>
                                    <div class="feedback"></div>
                                    <input id="new_password" class="pop-input" type="password" placeholder="Mật khẩu mới" name="password" required>
                                </div>
                                <div class="popup-form-row @if($errors->has('password_confirm')) popup-form-row-err @endif">
                                    <label for="pop-pw-form">Nhâp lại mật khẩu<i class="icons iLock"></i></label>
                                    <div class="feedback"></div>
                                    <input id="re_password" class="pop-input" type="password" placeholder="Nhâp lại mật khẩu" name="password_confirm" required>
                                </div>
                                <div class="popup-form-btn">
                                    <button type="button" onclick="shop.changeCustomerPassword()" class="fs-16 fw-rbb">{{ __('auth.capnhat') }}</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
