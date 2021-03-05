<div class="modal fade login-screen" id="loginForm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content  ">
            <div class="wrapper">
                <div id="formContent">
                    <!-- Tabs Titles -->
                    <ul class="nav nav-tabs" style="padding-left: 0 !important;" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active tab-login" style="" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                <i class="fa fa-user-secret"></i> Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab-reg" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <i class="fa fa-user-plus"></i> Đăng ký</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <!-- Icon -->
                            <div>
                                <img width="168" src="{{ asset('html/images/login-icon.svg') }}" class="icon" alt="Đăng nhập, đăng ký"/>
                            </div>
                            <!-- Login Form -->
                            <form class="mt-3" id="formLogin" onsubmit="return Member.doLogin('#loginForm')" method="post">
                                <input type="text"  class="input-text" name="userOrEmail" placeholder="Tài khoản hoặc Email...">
                                <input type="password" class="input-text"  id="password" name="password" placeholder="Mật khẩu...">
                                <input type="button" onclick="return Member.doLogin('#formLogin')" class="mt-3" value="Đăng nhập">
                            </form>
                            <div class="article-social">
                                <div class="login-social-icons">
                                    <ul>
                                        <li class="login-fb"><img src="{{ asset('html/images/facebook.svg') }}" alt="Đăng nhập bằng Facebook"><a href="#" rel="nofollow"> Đăng nhập bằng Facebook</a></li>
                                        <li class="login-gp"><img src="{{ asset('html/images/google-plus.svg') }}" alt="Đăng nhập bằng Google"><a href="#" rel="nofollow"> Đăng nhập bằng Google</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- Icon -->
                            <div>
                                <img width="168"  src="{{ asset('html/images/login-icon.svg') }}" class="icon" alt="Đăng nhập, đăng ký"/>
                            </div>

                            <!-- Login Form -->
                            <form class="mt-3" id="formRegister" method="post" onsubmit="return Member.doRegister('#formRegister')">
                                <input type="text" class="input-text"  name="user_name" placeholder="Username">
                                <input type="email" class="input-text"  name="email" placeholder="Email...">
                                <input type="password" class="input-text" name="password" placeholder="Mật khẩu...">
                                <input type="password" class="input-text"  name="password_confirmation" placeholder="Nhập lại mật khẩu...">
                                <input type="button" onclick="return Member.doRegister('#formRegister')" class="mt-3" value="Đăng ký">
                            </form>

                        </div>
                    </div>
                    <!-- Remind Passowrd -->
                    <div id="formFooter">
                        <a class="underlineHover" href="#">Quên mật khẩu?</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
    