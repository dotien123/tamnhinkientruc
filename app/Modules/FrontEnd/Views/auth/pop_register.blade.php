<div class="modal fade" id="pop_register" tabindex="-1" role="dialog" aria-labelledby="pop_registerModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-3">
            <form class="col-12 col-md-12">
                <!-- <div class="mb-2"><img src="{{asset('html-tophay/images/logo.png')}}" style="width: 90px"/></div> -->
                <h4>Đăng ký</h4>
                <div class="form-group">
                    <label for="user_name">Email</label>
                    <input type="text" class="form-control"  id="pop-email" aria-describedby="emailHelp" placeholder="Nhập email đăng ký">
                </div>
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" id="pop-pw" class="form-control" placeholder="Nhập mật khẩu">
                </div>
                <div class="form-group">
                    <label>Nhập lại mật khẩu</label>
                    <input type="password" id="pop-pw-rp" class="form-control" placeholder="Nhập lại mật khẩu">
                </div>
                <div class="w-100 align-items-center  d-flex mb-2">
                    <input type="checkbox" id="account_type" name="account_type">
                    <label class="mb-0 ml-2" for="account_type">Bằng việc đăng ký là thành viên viết bài của chúng tôi</label>
                </div>
                <button type="button" onclick="shop.register();" class="btn btn-reg btn-log m-auto" id="btn-login">ĐĂNG KÝ</button>
    
                <div class="box-login-other">
                    <div class="top-login text-center"><span>Hoặc</span></div>
                    <a href="{{ route('facebook.login') }}" class="btn-social btn-fb flex_center"><i class="icon-fb"></i>Đăng nhập bằng Facebook</a>
                </div>
            </form>
        </div>
    </div>
</div>