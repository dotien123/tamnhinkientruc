<!-- BEGIN: Footer-->
<footer class="footer @if(@$theme_customizer->footer_type == "footer-static") footer-static @elseif(@$theme_customizer->footer_type == "footer-hidden") d-none @endif footer-light">
    <p class="clearfix mb-0"><span class="float-left d-inline-block">2020 &copy; Bifzly</span><span
                class="float-right d-sm-inline-block d-none">Crafted with<i
                    class="bx bxs-heart pink mx-50 font-small-3"></i>by<a class="text-uppercase"
                                                                          href="https://www.facebook.com/kaynyz/"
                                                                          target="_blank">Bifzly</a></span>
        <button class="btn btn-primary btn-icon scroll-top @if(@$theme_customizer->hide_scroll_top_switch == 1) d-none @endif" type="button"><i class="bx bx-up-arrow-alt"></i></button>
    </p>
</footer>
<!-- END: Footer-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="mySmallModalLabel">Hỗ trợ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Liên hệ với <b>nhà phát triển</b> để được hỗ trợ bạn nhé!</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- BEGIN: Customizer-->
<div class="customizer d-none d-md-block">
    <a class="customizer-close" href="#"><i class="bx bx-x"></i></a>
    <a class="customizer-toggle" href="#"><i class="bx bx-cog bx bx-spin white"></i></a>
    <div class="customizer-content p-2">
        <form id="customizer-form">
            <h4 class="text-uppercase mb-0">Theme Customizer</h4>
            <small>Customize & Preview in Real Time</small>
            <hr>
            <!-- Theme options starts -->
            <h5 class="mt-1">Theme Layout</h5>
            <div class="theme-layouts">
                <div class="d-flex justify-content-start">
                    <div class="mx-50">
                        <fieldset>
                            <div class="radio">
                                <input type="radio" name="layoutOptions" value="false" id="radio-light" class="layout-name"
                                       data-layout=""
                                       @if(@$theme_customizer->layout_options == '') checked @endif>
                                <label for="radio-light">Light</label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="mx-50">
                        <fieldset>
                            <div class="radio">
                                <input type="radio" name="layoutOptions" value="false" id="radio-dark" class="layout-name"
                                       data-layout="dark-layout" @if(@$theme_customizer->layout_options == 'dark-layout') checked @endif>
                                <label for="radio-dark">Dark</label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="mx-50">
                        <fieldset>
                            <div class="radio">
                                <input type="radio" name="layoutOptions" value="false" id="radio-semi-dark"
                                       class="layout-name"
                                       data-layout="semi-dark-layout" @if(@$theme_customizer->layout_options == 'semi-dark-layout') checked @endif>
                                <label for="radio-semi-dark">Semi Dark</label>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <!-- Theme options starts -->
            <hr>

            <!-- Menu Colors Starts -->
            <div id="customizer-theme-colors">
                <h5>Menu Colors</h5>
                <ul class="list-inline unstyled-list">
                    <li class="color-box bg-primary {{ @$theme_customizer->navbar_colors === 'bg-primary' ? 'selected' : '' }}" data-color="theme-primary"></li>
                    <li class="color-box bg-success {{ @$theme_customizer->navbar_colors === 'bg-success' ? 'selected' : '' }}" data-color="theme-success"></li>
                    <li class="color-box bg-danger {{ @$theme_customizer->navbar_colors === 'bg-danger' ? 'selected' : '' }}" data-color="theme-danger"></li>
                    <li class="color-box bg-info {{ @$theme_customizer->navbar_colors === 'bg-info' ? 'selected' : '' }}" data-color="theme-info"></li>
                    <li class="color-box bg-warning {{ @$theme_customizer->navbar_colors === 'bg-warning' ? 'selected' : '' }}" data-color="theme-warning"></li>
                    <li class="color-box bg-dark {{ @$theme_customizer->navbar_colors === 'bg-dark' ? 'selected' : '' }}" data-color="theme-dark"></li>
                </ul>
                <hr>
            </div>
            <!-- Menu Colors Ends -->
            <!-- Menu Icon Animation Starts -->
            <div id="menu-icon-animation">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="icon-animation-title">
                        <h5 class="pt-25">Icon Animation</h5>
                    </div>
                    <div class="icon-animation-switch">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" @if(@$theme_customizer->icon_animation_switch) checked @endif id="icon-animation-switch">
                            <label class="custom-control-label" for="icon-animation-switch"></label>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <!-- Menu Icon Animation Ends -->
            {{--<!-- Collapse sidebar switch starts -->
            <div class="collapse-sidebar d-flex justify-content-between align-items-center">
                <div class="collapse-option-title">
                    <h5 class="pt-25">Collapse Menu</h5>
                </div>
                <div class="collapse-option-switch">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="collapse-sidebar-switch">
                        <label class="custom-control-label" for="collapse-sidebar-switch"></label>
                    </div>
                </div>
            </div>
            <!-- Collapse sidebar switch Ends -->
            <hr>--}}

            <!-- Navbar colors starts -->
            <div id="customizer-navbar-colors">
                <h5>Navbar Colors</h5>
                <ul class="list-inline unstyled-list">
                    <li class="color-box bg-white border" data-navbar-default=""></li>
                    <li class="color-box bg-primary {{ @$theme_customizer->navbar_colors === 'bg-primary' ? 'selected' : '' }}" data-navbar-color="bg-primary"></li>
                    <li class="color-box bg-success {{ @$theme_customizer->navbar_colors === 'bg-success' ? 'selected' : '' }}" data-navbar-color="bg-success"></li>
                    <li class="color-box bg-danger {{ @$theme_customizer->navbar_colors === 'bg-danger' ? 'selected' : '' }}" data-navbar-color="bg-danger"></li>
                    <li class="color-box bg-info {{ @$theme_customizer->navbar_colors === 'bg-info' ? 'selected' : '' }}" data-navbar-color="bg-info"></li>
                    <li class="color-box bg-warning {{ @$theme_customizer->navbar_colors === 'bg-warning' ? 'selected' : '' }}" data-navbar-color="bg-warning"></li>
                    <li class="color-box bg-dark {{ @$theme_customizer->navbar_colors === 'bg-dark' ? 'selected' : '' }}" data-navbar-color="bg-dark"></li>
                </ul>
                <small><strong>Note :</strong> This option with work only on sticky navbar when you scroll page.</small>
                <hr>
            </div>
            <!-- Navbar colors starts -->
            <!-- Navbar Type Starts -->
            <h5>Navbar Type</h5>
            <div class="navbar-type d-flex justify-content-start">
                <div class="hidden-ele mx-50">
                    <fieldset>
                        <div class="radio">
                            <input type="radio" name="navbarType" value="false" id="navbar-hidden">
                            <label for="navbar-hidden">Hidden</label>
                        </div>
                    </fieldset>
                </div>
                <div class="mx-50">
                    <fieldset>
                        <div class="radio">
                            <input type="radio" name="navbarType" @if(@$theme_customizer->navbar_type === "navbar-static") checked @endif value="false" id="navbar-static">
                            <label for="navbar-static">Static</label>
                        </div>
                    </fieldset>
                </div>
                <div class="mx-50">
                    <fieldset>
                        <div class="radio">
                            <input type="radio" name="navbarType" @if(@$theme_customizer->navbar_type === "navbar-sticky" || !isset($theme_customizer)) checked @endif value="false" id="navbar-sticky">
                            <label for="navbar-sticky">Fixed</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <hr>
            <!-- Navbar Type Starts -->

            <!-- Footer Type Starts -->
            <h5>Footer Type</h5>
            <div class="footer-type d-flex justify-content-start">
                <div class="mx-50">
                    <fieldset>
                        <div class="radio">
                            <input type="radio" name="footerType" @if(@$theme_customizer->footer_type == "footer-hidden") checked @endif value="false" id="footer-hidden">
                            <label for="footer-hidden">Hidden</label>
                        </div>
                    </fieldset>
                </div>
                <div class="mx-50">
                    <fieldset>
                        <div class="radio">
                            <input type="radio" name="footerType" @if(@$theme_customizer->footer_type == "footer-static" || !isset($theme_customizer)) checked @endif value="false" id="footer-static">
                            <label for="footer-static">Static</label>
                        </div>
                    </fieldset>
                </div>
                <div class="mx-50">
                    <fieldset>
                        <div class="radio">
                            <input type="radio" name="footerType" @if(@$theme_customizer->footer_type == "fixed-footer") checked @endif value="false" id="footer-sticky">
                            <label for="footer-sticky" class="">Sticky</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!-- Footer Type Ends -->
            <hr>

            <!-- Card Shadow Starts-->
            <div class="card-shadow d-flex justify-content-between align-items-center py-25">
                <div class="hide-scroll-title">
                    <h5 class="pt-25">Card Shadow</h5>
                </div>
                <div class="card-shadow-switch">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" @if(@$theme_customizer->card_shadow_switch) checked @endif id="card-shadow-switch">
                        <label class="custom-control-label" for="card-shadow-switch"></label>
                    </div>
                </div>
            </div>
            <!-- Card Shadow Ends-->
            <hr>

            <!-- Hide Scroll To Top Starts-->
            <div class="hide-scroll-to-top d-flex justify-content-between align-items-center py-25">
                <div class="hide-scroll-title">
                    <h5 class="pt-25">Hide Scroll To Top</h5>
                </div>
                <div class="hide-scroll-top-switch">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" @if(@$theme_customizer->hide_scroll_top_switch) checked @endif id="hide-scroll-top-switch">
                        <label class="custom-control-label" for="hide-scroll-top-switch"></label>
                    </div>
                </div>
            </div>
            <!-- Hide Scroll To Top Ends-->
        </form>
    </div>
</div>
<!-- End: Customizer-->


<div class="sidenav-overlay"></div>
<div class="drag-target"></div>