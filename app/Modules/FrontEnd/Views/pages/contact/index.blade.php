@extends('FrontEnd::layouts.home')

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop
@section('metaTitle', 'Liên hệ đặt hàng')
@section('CONTENT_REGION')

@include('FrontEnd::layouts.banner_page')

{{-- <div class="empty-space d-none d-lg-block" style="height: 55px;"></div> --}}

<div class="box__content--contact-book" style="margin-top: 20px;">
    <div class="container">
        <div class="breadcum__detail--product" style="margin-top: 40px;margin-bottom: 20px;">
            <div class="container">
                <span style="text-transform: capitalize;"><a href="{{ asset('/') }}" title="Trang chủ">trang chủ </a>/ liên hệ </span>
            </div>
        </div>

        <div class="row flex-lg-row-reverse">
            <div class="col-lg-9 col-12">
                <div class="heading__title">
                    <span>Liên hệ và đặt hàng</span>
                    <img src="{{ asset('template/images/shopping-cart.png') }}" alt="icon web">
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        @include('FrontEnd::pages.contact.include.form_subscriber')
                    </div>
                    <div class="col-lg-6 col-12">
                        {{-- <div class="d-flex d-lg-block fb-meta">
                            <div class="fb-like" style="margin-bottom: 5px;" data-href="{{ asset('/lien-he-m189') }}"
                                data-width="" data-layout="button_count" data-action="like" data-size="large"
                                data-share="true"></div>
                            <div class="addthis_inline_share_toolbox"></div>
                        </div> --}}
                        @include('FrontEnd::layouts.social')

                        <div class="margin__top">
                            <div class="form__contact">
                                <img src="{{ asset('template/images/payment.png') }}" alt="icon web">
                                <span style="vertical-align: middle; padding-left: 10px;">Thông tin giao dịch</span>
                            </div>
                            <div class="contact-book__content">
                                <span class="sub__heading--title">Chính sách</span>
                                <p class="small--sub">Chính sách mua hàng- chính sách thanh toán-
                                    Chính sách bảo mật</p>
                                <span class="main__title">CÔNG TY CỔ PHẦN XUẤT NHẬP KHẨU Ô TÔ LONG BIÊN</span>
                                <div class="box__content--company">
                                    <p>{!! $config['code_company'] !!}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="box__small--info">
                                        <img src="{{ asset('template/images/fax.png') }}" alt="icon web">
                                        <span>{{ $config['phone_hcm'] }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="box__small--info">
                                        <img src="{{ asset('template/images/global.png') }}" alt="icon web">
                                        <span>www.otolongbien.com.vn</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="box__small--info">
                                        <img src="{{ asset('template/images/phone.png') }}" alt="icon web">
                                        <span>{{ $config['phone_contact'] }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="box__small--info">
                                        <img src="{{ asset('template/images/mail.png') }}" alt="icon web">
                                        <span>{{ $config['email'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="box__images--verify">
                                <img src="{{ asset('template/images/bct.png') }}" alt="icon web">
                            </div>
                        </div>
                    </div>
                </div>

                @include('FrontEnd::layouts.comment')

            </div>
            <div class="col-lg-3 col-12">
                @include('FrontEnd::layouts.sidebar')
            </div>
        </div>
    </div>
</div>
<!-- form lien he-->
@endsection

@section('CSS_REGION')

@endsection
@push('JS_PLUGINS_REGION')

@endpush