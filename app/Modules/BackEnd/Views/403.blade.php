<!DOCTYPE html>
<!--
Template Name: Frest HTML Admin Template
Author: :Pixinvent
Website: http://www.pixinvent.com/
Contact: hello@pixinvent.com
Follow: www.twitter.com/pixinvents
Like: www.facebook.com/pixinvents
Purchase: https://1.envato.market/pixinvent_portfolio
Renew Support: https://1.envato.market/pixinvent_portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.

-->
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<!-- Mirrored from www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/html/ltr/horizontal-menu-template/page-not-authorized.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 09 May 2020 15:11:39 GMT -->
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <meta name="description" content="Bạn không có quyền xem thư mục hoặc trang này bằng thông tin đăng nhập mà bạn đã cung cấp.">
  <meta name="author" content="PIXINVENT">
  <title>Không có quyền truy cập</title>
  <link rel="shortcut icon" type="image/x-icon" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/images/ico/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

  @foreach($def['site_css'] as $css)
    {!! \Lib::addMedia($css) !!}
  @endforeach

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="horizontal-layout horizontal-menu navbar-sticky 1-column footer-static bg-full-screen-image blank-page blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body"><!-- not authorized start -->
      <section class="row flexbox-container">
        <div class="col-xl-7 col-md-8 col-12">
          <div class="card bg-transparent shadow-none">
            <div class="card-content">
              <div class="card-body text-center bg-transparent miscellaneous">
                <img src="{{ admin_link('frest-admin/app-assets/images/pages/not-authorized.png') }}" class="img-fluid" alt="not authorized" width="400">
                <h1 class="my-2 error-title">Bạn không có quyền truy cập dữ liệu này!</h1>
                <p>
                  Bạn không có quyền xem thư mục hoặc trang này bằng thông tin đăng nhập mà bạn đã cung cấp.
                </p>
                <a href="{{ route('admin.home') }}" class="btn btn-primary round glow mt-2">Trở về trang chủ</a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- not authorized end -->

    </div>
  </div>
</div>
<!-- END: Content-->

@foreach($def['site_js'] as $js)
  {!! \Lib::addMedia($js) !!}
@endforeach

</body>
<!-- END: Body-->

<!-- Mirrored from www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/html/ltr/horizontal-menu-template/page-not-authorized.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 09 May 2020 15:11:39 GMT -->
</html>