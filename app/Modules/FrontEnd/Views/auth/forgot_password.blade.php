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

                                @if($token)
                                    {!! Form::open(['url' => route('password.reset.post')]) !!}
                                    <div class="popup-form-row @if($errors->has('email')) popup-form-row-err @endif">
                                        <label for="pop-email-form"><i class="icons iEmail3"></i></label>
                                        <input id="pop-email-form" class="pop-input" type="text" placeholder="{{ __('auth.email') }}" name="email" value="{{ old('email') }}" required autofocus>
                                        <input type="hidden" value="{{ $token->token }}" name="token">
                                    </div>

                                    <div class="popup-form-row @if($errors->has('password')) popup-form-row-err @endif">
                                        <label for="pop-pw-form"><i class="icons iLock"></i></label>
                                        <input id="pop-pw-form" class="pop-input" type="password" placeholder="{{ __('auth.matkhau') }}" name="password" required>
                                    </div>

                                    <div class="popup-form-row @if($errors->has('password_confirm')) popup-form-row-err @endif">
                                        <label for="pop-pw-form"><i class="icons iLock"></i></label>
                                        <input id="pop-pw-form" class="pop-input" type="password" placeholder="{{ __('auth.nhaplaimatkhau') }}" name="password_confirm" required>
                                    </div>

                                    <div class="popup-form-btn">
                                        <button class="fs-16 fw-rbb">{{ __('auth.capnhat') }}</button>
                                    </div>
                                    {!! Form::close() !!}
                                @else
                                    <div class="alert alert-danger">
                                        Yêu cầu của bạn không hợp lệ hoặc đã bị quá hạn. Vui lòng <a href="{{ route('password') }}"><b>thực hiện lại</b></a> thao tác.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
