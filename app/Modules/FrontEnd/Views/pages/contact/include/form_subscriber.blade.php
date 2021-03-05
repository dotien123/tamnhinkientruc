<form id="subscribe">
    <div class="form__contact">
        <span>Gửi thông tin đặt hàng</span>
        <div class="form__input">
            <input type="text" name="fullname" id="name_1" placeholder="Họ và tên*">

            <input type="text" name="address" id="address_1" placeholder="Địa chỉ">

            <input type="number" name="phone" id="phone_1" placeholder="Điện thoại*">

            <input type="email" name="email" id="email_1" placeholder="Email*">

            <input type="text" name="title_product" id="title_1" placeholder="Sản phẩm quan tâm">
            <input type="hidden" name="type" value="1">

            <textarea name="content" id="textbox_1" cols="30" rows="10" placeholder="Nội dung"></textarea>

            <div class="code__safe-contact-book" style="margin-bottom: 10px">
                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
            </div>
            
            <a title="gửi" href="javascript:;" class="btn-send-reg" onclick="shop.subscribe()"
                style="width: fit-content;background: #0092E8;border-radius: 7px;color: #fff;font-weight: bold;font-size: 16px;letter-spacing: 0.03em;padding: 9px 43px;margin-bottom:30px">Gửi
                đi</a>
        </div>
    </div>
</form>

