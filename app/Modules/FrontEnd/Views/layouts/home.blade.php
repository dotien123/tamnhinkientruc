<!DOCTYPE html>
<html lang="{{ $defLang }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="{{ csrf_token() }}" name="_token">
    <meta name="title" content="@yield('metaTitle')">


    <link rel="shortcut icon" href="{{  asset('template/images/logo.jpg') }}" type="image/x-icon">
    <meta property="fb:app_id" content="{{ @$config['fb_app_id'] }}" />
    {{--<meta property="fb:admins" content="{{ @$config['fb_admins_id'] }}" />--}}
    {!! SEO::generate() !!}
    @yield('CSS_REGION')
    <!-- Icons -->

    @foreach($def['site_media'] as $css)
    {!! \Lib::addMedia($css) !!}
    @endforeach

    <!-- Main styles for this application -->
    @foreach($def['site_css'] as $css)
    {!! \Lib::addMedia($css) !!}
    @endforeach

    @yield('css_top')
    @yield('css')
    @yield('js_top')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js" ></script> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">


    {{-- {!! @$config['script_head'] !!} --}}
</head>

<body>
    <div class="container">
        <div class="header">
            <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
                <a href="/" class="navbar-brand"><img src="{{ asset('template') }}/images/logo.jpg" alt=""></a>

                <ul class="navbar-nav">
                    @if(!empty($menu))
                    @foreach($menu as $k => $v)
                    <li class="nav-item">
                        <a class="nav-link {{ $active == $v['alias'] ? 'active'  : ''}}"
                            href="{{ $v['alias'] ?? '#' }}">{{ $v['title'] }}</a>
                    </li>
                    @endforeach
                    @endif

                </ul>
            </nav>
        </div>
        @yield('CONTENT_REGION')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

    <!-- <a href="javascript:void(0)" class="back-to-top"><i class="fa fa-chevron-up"></i></a> -->
    <script type="text/javascript">
        var ENV = {
        version: '{{ env('APP_VER', 0) }}',
        token: '{{ csrf_token() }}',
        @foreach($def['site_js_val'] as $key => $val)
                {{$key}}: '{{$val}}',
        @endforeach
            },
        COOKIE_ID = '{{ env('APP_NAME', '') }}',
        DOMAIN_COOKIE_REG_VALUE = 1,
        DOMAIN_COOKIE_STRING = '{{ config('session.domain') }}';
    </script>

    @if ( env('APP_DEBUG') )
    {!! \Lib::addMedia('js/prettyprint.js') !!}
    @endif

    <!-- Bootstrap and necessary plugins -->
    @foreach($def['site_js'] as $js)
        {!! \Lib::addMedia($js) !!}
    @endforeach
    <!-- Plugin js-->
    {{-- @stack('JS_PLUGINS_REGION') --}}
    <!-- Init js-->
    @stack('JS_REGION')

</body>

</html>