@extends('FrontEnd::layouts.home', ['bodyClass' => 'has-cover'])

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop

@section('content')
    <div class="banner_landing">
        <img class="w-100" src="{{ asset('html-washfriends/images/banner_landing.png') }}" alt="">
        <div class="bg-menu-drop">
            <img src="{{ asset('html-washfriends/images/image-banner-menu-scroll.png') }}" usemap="#image-map">
            <map name="image-map">
                <area target="" alt="" title="" href="#step-1" coords="426,201,573,325" shape="rect">
                <area target="" alt="" title="" href="#step-2" coords="790,126,984,282" shape="rect">
                <area target="" alt="" title="" href="#step-3" coords="1123,119,1323,270" shape="rect">
                <area target="" alt="" title="" href="#step-4" coords="1723,335,1493,144" shape="rect">
            </map>
        </div>
    </div>
    @for($i = 1; $i <= 4; $i++)
    <div class="step-scroll-{{$i}}" id="step-{{$i}}">
        <img src="{{ asset('html-washfriends/images/bg-step-'.$i.'.png') }}" alt="">
        <div class="step-scroll-content-wrap container position-absolute">
            <div class="step-scroll-content">
                <h5>{{ $config['step_title_'.$i] }}</h5>
                <figure>
                    <img src="{{ !empty($config['step_images_'.$i]) ? $config['step_images_'.$i] : '' }}" alt="">
                </figure>
                <p>{{ $config['step_details_'.$i] }}</p>
                @if($i == 4 && !empty($config['link_news'])) <a href="{{ $config['link_news'] }}">Tìm hiểu thêm <i class="fa fa-angle-right" aria-hidden="true"></i></a> @endif
            </div>
        </div>
    </div>
    @endfor

    <div class="time_down">
        <div class="block-title">
            <div class="container text-center">
                <img src="{{ asset('html-washfriends/images/title-image.png') }}" alt="">
                <p>
                    Những chuyến đi nối ti ếp chuyến đi, chúng tôi tin rằng từ hành trình đầu tiên này sẽ lan tỏa rộng rãi
                    để có thêm những hành trình mới, đến với những tỉnh thành mới.
                    <a href="#">Đâu cần chúng tôi có</a>, nơi nào <a href="#">người bệnh gặp khó khăn</a> chúng tôi luôn sẵn lòng cùng bạn vượt qua,
                    cũng bạn <a href="#">giành lại sức khỏe</a> đến cùng.
                </p>
            </div>
        </div>
        <div class="block-time">
            <div id="clockdiv" class="container">
                <div class="block">
                    <span class="days">123</span>
                    <div class="smalltext">Ngày</div>
                </div>
                <div class="block">
                    <span class="hours">8</span>
                    <div class="smalltext">Giờ</div>
                </div>
                <div class="block">
                    <span class="minutes">11</span>
                    <div class="smalltext">Phút</div>
                </div>
                <div class="block">
                    <span class="seconds">30</span>
                    <div class="smalltext">Giây</div>
                </div>
            </div>
        </div>
    </div>
    <div class="landing-cong-dong">
        <h5>Cùng Cotarin Viết Nên Giá Trị Nhân Văn Cho Cộng đồng</h5>
        <img src="{{ asset('html-washfriends/images/cong-dong-img.png') }}" alt="">
    </div>
@endsection

