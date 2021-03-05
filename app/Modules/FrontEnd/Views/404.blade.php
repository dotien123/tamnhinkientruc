<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="{{$def['site_description']}}">
  <meta name="keyword" content="{{$def['site_keyword']}}">

  <link rel="shortcut icon" href="{{asset($def['favicon'])}}">

  {!! \Lib::siteTitle('404 - Page Not Found') !!}
  {!! \Lib::addMedia('css/404.css') !!}
  <style>
    html, body {
        min-height: 100%;
        height: 100%;
    }

    body {
        background-color: #041835;
        overflow: hidden;
    }
    span.lg_fk.logo-default {
        color: #fff;
        font-size: 48px;
    }
</style>
</head>

<body class="tw-p-8 lg:tw-p-0">
  <div id="lottie" class="tw-w-full tw-h-full tw-hidden lg:tw-block lg:tw-fixed"></div>
  <div class="lg:tw-w-3/4 tw-mx-auto lg:tw-pl-8 tw-text-center lg:tw-text-left tw-h-full">
      <div class="lg:tw-absolute tw-top-0 tw-h-full tw-flex tw-flex-col tw-justify-center tw-z-10">
          <a href="{{ route('home') }}" class="logo">
              <!-- logo for regular state and mobile devices -->
              <h1 class="header-logo display-flex">
                  <span class="lg_fk logo-default" style="text-transform: uppercase;">
                       {{ env('APP_NAME') }}
                  </span>
  
              </h1>
          </a>
          <h1 class="tw-text-white tw-font-normal tw-tracking-wide tw-text-3xl tw-mb-6">Bạn đã mạo hiểm vào không gian 404.</h1>
          <p class="tw-text-grey-dark tw-mb-8 tw-text-base tw-leading-normal tw-font-light">
              We are the Borg. Your biological and technological<br class="tw-hidden lg:tw-inline"> distinctiveness will be added to our own. Resistance is futile.
          </p>
          <div class="tw-flex tw-flex-col lg:tw-flex-row tw-mt-4 tw-mx-auto lg:tw-mx-0">
              <a href="{{ route('home') }}" class="tw-btn tw-text-white tw-px-8 hover:tw-text-blue hover:tw-bg-white">Trở về trang chủ</a>
          </div>
      </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/4.13.0/bodymovin_light.min.js" type="0519a05a907357344fac7735-text/javascript"></script>
  <script type="0519a05a907357344fac7735-text/javascript">
              bodymovin.loadAnimation({
                  container: document.getElementById('lottie'),
                  path: '{{ asset('js/404.json') }}',
                  renderer: 'svg',
                  loop: true,
                  autoplay: true
              });
          </script>
  <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="0519a05a907357344fac7735-|49" defer=""></script></body>
  

</html>