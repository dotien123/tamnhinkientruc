@extends('FrontEnd::layouts.home', ['bodyClass' => 'has-cover'])

@section('title') {!! \Lib::siteTitle($site_title, $def['site_title']) !!} @stop

@section('content')
    <div class="journey-mobile-2">
        <div class="banner"><img src="{{ asset('html-washfriends/images/journey-2-banner.png') }}" alt=""></div>
        <div class="content first-section">
            <div class="title main-title">Tiểu đường là nguyên nhân <br> <span>Gây tử vong cao thứ 3 tại Việt Nam</span></div>
            <div class="title sub-title">Những con số <span>biết nói</span> về bệnh tiểu đường</div>
            <div class="js-carousel slide-first-section" data-loop="false" data-items="1" data-dots="true" data-arrows="true" data-margin="20">
                <div class="items">
                    <div class="item-image"><img src="{{ asset('html-washfriends/images/icon-journey-1.png') }}" alt=""></div>
                    <div class="item-line"></div>
                    <div class="item-desc"><span>70%</span> người Việt Nam mắc đái tháo đường chưa được chuẩn đoán</div>
                </div>
                <div class="items">
                    <div class="item-image"><img src="{{ asset('html-washfriends/images/icon-journey-2.png') }}" alt=""></div>
                    <div class="item-line"></div>
                    <div class="item-desc"><span>70%</span> người Việt Nam mắc đái tháo đường chưa được chuẩn đoán</div>
                </div>
                <div class="items">
                    <div class="item-image"><img src="{{ asset('html-washfriends/images/icon-journey-3.png') }}" alt=""></div>
                    <div class="item-line"></div>
                    <div class="item-desc"><span>70%</span> người Việt Nam mắc đái tháo đường chưa được chuẩn đoán</div>
                </div>
                <div class="items">
                    <div class="item-image"><img src="{{ asset('html-washfriends/images/icon-journey-4.png') }}" alt=""></div>
                    <div class="item-line"></div>
                    <div class="item-desc"><span>70%</span> người Việt Nam mắc đái tháo đường chưa được chuẩn đoán</div>
                </div>
            </div>
        </div>

        <div class="content second-section">
            <div class="title main-title">Dự kiến năm 2045 <span>có 6.13 triệu người</span> mắc bệnh</div>
            <div class="image"><img src="{{ asset('html-washfriends/images/journey-2-img-1.png') }}" alt=""></div>
            <div class="desc">
                <div class="wrap">
                    <h4>Biến chứng</h4>
                    <p>“ Ai cũng biết tiểu <br> đường nếu không kiểm  <br>soát tốt sẽ tăng nguy cơ <br> biến chứng nguy hiểm <br> như bệnh tim, đột quỵ,  <br>huyết áp cao, mù, thận, <br> cắt chi,... tử vong ”</p>
                </div>
            </div>
        </div>

        <div class="line">
            <img src="{{ asset('html-washfriends/images/journey-2-line.png') }}" alt="">
        </div>

        <div class="content third-section">
            <div class="third-section-title">Kiểm soát đường huyết là điều tối quan trọng để ngăn ngừa biến chứng</div>
            <div class="image">
                <div class="wrap">
                    <img src="{{ asset('html-washfriends/images/journey_doctor.png') }}" alt="">
                </div>
            </div>
        </div>

        <img src="{{ asset('html-washfriends/images/journey-2-img-2.png') }}" alt="" class="image-stc">

        <div class="content four-section">
            <div class="title main-title">Hành trình <span>không điểm dừng</span></div>
            <div class="desc">
                Bệnh mãn tính nói chung, tiểu đường nói riêng sẽ không thể chữ khỏi hoàn toàn, <span> chúng tôi cam kết  sẽ đồng hành cùng bạn trong suốt chặng đường khó khăn phía trước </span>, thành công của Cotarin đường huyết sẽ là nguồn động lực giúp chúng tôi <span> lan tỏa và kéo dài mãi chuyến hành trình </span> đầy ý nghĩa này
            </div>
        </div>

        <div class="content five-section">
            <div class="five-section-title">Cùng Cotarin Đường Huyết lan tỏa và <span>kéo dài mãi hành trình đầy ý nghĩa</span></div>
            <img src="{{ asset('html-washfriends/images/journey-2-img-3.png') }}" alt="">
        </div>

        <div class="content six-section">
            <div class="six-section-title">Sự kiện đang diễn ra</div>
            <div class="js-carousel slide-six-section" data-items="1" data-dots="true" data-arrows="true" data-margin="20">
                <div class="items">
                    <div class="item-image">
                        <div class="wrap">
                            <img src="{{ asset('html-washfriends/images/slide_demo_six.png') }}" alt="">
                        </div>
                    </div>
                    <div class="item-desc">Ai cũng biết tiểu đường nếu không kiểm soát tốt sẽ tăng nguy cơ biến chứng nguy hiểm như bệnh tim, đột quỵ, huyết áp cao, mù, thận, cắt chi,... tử vong</div>
                </div>
                <div class="items">
                    <div class="item-image"><img src="{{ asset('html-washfriends/images/slide_demo_six.png') }}" alt=""></div>
                    <div class="item-desc">Ai cũng biết tiểu đường nếu không kiểm soát tốt sẽ tăng nguy cơ biến chứng nguy hiểm như bệnh tim, đột quỵ, huyết áp cao, mù, thận, cắt chi,... tử vong</div>
                </div>
            </div>
        </div>
    </div>
@endsection

