<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{$def['site_description']}}">
    <meta name="keyword" content="{{$def['site_keyword']}}">
    <link rel="shortcut icon" href="{{ @$def['favicon_images']?:public_link('favicon.ico') }}" type="image/x-icon">
    @yield('title')
<!-- Icons -->
    @foreach($def['site_media'] as $css)
        <link href="{{ asset($css) }}?ver={{$def['version']}}" rel="stylesheet">
    @endforeach

<!-- Main styles for this application -->
    @foreach($def['site_css'] as $css)
        <link href="{{ asset($css)  }}?ver={{$def['version']}}" rel="stylesheet">
    @endforeach
    <style>
        html,
        body {
            height: 100%;
        }
        body {
            padding-bottom: 0;
        }
    </style>
</head>
<!-- BEGIN: Body-->
<body class="horizontal-layout horizontal-menu navbar-sticky 1-column   footer-static bg-full-screen-image  blank-page blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            @yield('CONTENT_REGION')
        </div>
    </div>
</div>
<!-- END: Content-->



<!-- BEGIN: Page JS-->
<!-- END: Page JS-->
<script>
    var ENV = {
        version: '{{ env('APP_VER', 1) }}',
    @foreach($def['site_js_val'] as $key => $val)
    {{$key}}: '{{$val}}',
    @endforeach
    };
</script>
</body>
<!-- END: Body-->
</html>