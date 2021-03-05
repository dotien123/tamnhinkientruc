<!DOCTYPE html>
<html lang="{{ $defLang }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{$def['site_description']}}">
    <meta name="keyword" content="{{$def['site_keyword']}}">
    <link rel="shortcut icon" href="{{ @$def['favicon_images']?:public_link('favicon.ico') }}" type="image/x-icon">
@if(\View::hasSection('TITLE_REGION'))
    @yield('TITLE_REGION')
@else
    {!! \Lib::siteTitle($site_title, $def['site_title']) !!}
@endif

<!-- Styles required by this views -->
@yield('CSS_REGION')

<!-- Icons -->
@foreach($def['site_media'] as $css)
    {!! \Lib::addMedia($css) !!}
@endforeach

<!-- Main styles for this application -->
@foreach($def['site_css'] as $css)
    {!! \Lib::addMedia($css) !!}
@endforeach
@stack('css_after_all')
<!-- top script -->
@yield('js_top')

</head>
@php($theme_customizer = \App\Models\User::getThemeCustomizer())
<!-- BEGIN: Body-->
<body class="horizontal-layout horizontal-menu {{ @$theme_customizer->navbar_type?:'navbar-sticky' }} 2-columns {{ @$theme_customizer->footer_type }} {{ @$theme_customizer->layout_options }} {{ @$theme_customizer->card_shadow_switch ? '' : 'no-card-shadow'}}" data-open="click" data-menu="horizontal-menu" data-col="2-columns">

<!-- Pre-loader -->
@stack('preloader')

<!-- End Preloader-->
@include("BackEnd::layouts.header")


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        @if(\View::hasSection('BREADCRUMB_REGION'))
            @yield('BREADCRUMB_REGION')
        @else
            {!! \Lib::renderBreadcrumb() !!}
        @endif
        <div class="content-body">
            @yield('CONTENT_REGION')
        </div>
        <div class="preview"></div>
    </div>
</div>
<!-- END: Content-->
@include("BackEnd::layouts.footer")

@stack('NOTICE_REGION')

<script type="text/javascript">
    var ENV = {
        version: '{{ env('APP_VER', 0) }}',
        token: '{{ csrf_token() }}',
@foreach($def['site_js_val'] as $keyjs => $val)
        {{$keyjs}}: '{{$val}}',
@endforeach
    },
    COOKIE_ID = '{{ env('APP_NAME', '') }}',
    DOMAIN_COOKIE_REG_VALUE = 1,
    DOMAIN_COOKIE_STRING = '{{ config('session.domain') }}';
</script>

@if ( env('APP_DEBUG') )
{!! \Lib::addMedia('js/prettyprint.js') !!}
@endif

<!-- vendor script -->
@foreach($def['site_js'] as $js)
    {!! \Lib::addMedia($js) !!}
@endforeach

@stack('JS_PLUGINS_REGION')
<!-- Init js-->
@stack('JS_REGION')
<!-- App js-->
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->

<script type="text/javascript">
    jQuery(document).ready(shop.ready.run);
    $(window).bind("load", function() {
        if($('body').hasClass('navbar-static')) {
            $('.menu-fck').addClass('navbar-sticky');
        }

        $('.xoa-ban-ghi').click(function (event) {
            event.preventDefault();
            SHOW_POPUP_LINK($(this).attr('href'), 'Xóa bản ghi', 'Bạn có chắc chắn muốn xóa bản ghi này?')
        })
        0 < $(".content-wrapper").length && $("input,select,textarea").not("[type=submit]").jqBootstrapValidation()
    });
    jQuery(document).ready(function () {
        toastr.options.progressBar = true;
        @if(session('status'))
            toastr.info('{!! session("status") !!}');
        @endif
        @if( count($errors) > 0)
            var err = '{!! json_encode($errors->all()) !!}';
            err = JSON.parse(err);
            $.each(err, function(i, e) {
                toastr.error(e, "Thông báo lỗi!", {timeOut: 5e3})
            })
        @endif
        if($("#customizer-navbar-colors .color-box.selected").length == 0) {
            $("#customizer-navbar-colors .color-box.bg-primary").addClass("selected")
        }
        $('#search').change(function () {
            $('#search').trigger('submit');
        });
        $("input.placement").maxlength({
            alwaysShow: !0,
            placement: "top",
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        });
        $('[data-toggle="select2"]').select2();
        $('[data-option-select2="tag"]').select2({
            tags: true
        });

        $('#table-extended-chechbox').on('click','.checkbox-all-item-input',(function () {
            $('.check-item').prop("checked", $('.checkbox-all-item-input').prop("checked"))
            if ($("input[name='checkbox-item-input[]']:checked").length > 0) {
                $('#popup-action').removeClass('d-none')
            } else {
                $('#popup-action').addClass('d-none')
            }
        }));
        $('#table-extended-chechbox').on('click','.checkbox-item-input',(function () {
            var check = ($('.checkbox-item-input').filter(":checked").length == $('.checkbox-item-input').length);
            $('.checkbox-all-item-input').prop("checked", check);
            if ($("input[name='checkbox-item-input[]']:checked").length > 0) {
                $('#popup-action').removeClass('d-none')
            } else {
                $('#popup-action').addClass('d-none')
            }
        }));

        if($('#customizer-form').length == 1) {
            var navbarColors;
            $('#customizer-navbar-colors .color-box').click(function () {
                navbarColors = $(this).data('navbar-color');
                let collapseSidebarSwitch = $('#collapse-sidebar-switch').prop("checked");
                let iconAnimationSwitch = $('#icon-animation-switch').prop("checked");
                let cardShadowSwitch = $('#card-shadow-switch').prop("checked");
                let hideScrollTopSwitch = $('#hide-scroll-top-switch').prop("checked");
                let layoutOptions = $('input[name="layoutOptions"]:checked').data('layout');
                let navbarType = $('input[name="navbarType"]:checked').attr('id');
                let footerType = $('input[name="footerType"]:checked').attr('id');
                shop.ajax_popup('user/customizer', 'POST', {
                    'collapseSidebarSwitch': collapseSidebarSwitch,
                    'iconAnimationSwitch': iconAnimationSwitch,
                    'cardShadowSwitch': cardShadowSwitch,
                    'hideScrollTopSwitch': hideScrollTopSwitch,
                    'layoutOptions': layoutOptions,
                    'navbarColors': navbarColors,
                    'navbarType': navbarType,
                    'footerType': footerType,
                }, function(json){
                    if(json.error == 1) {
                        Swal.fire({
                            title: 'Oops!',
                            text: json.msg,
                            type: "warning",
                            showCancelButton: !0,
                            showConfirmButton: 0,
                            cancelButtonColor: "#d33",
                            cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                            buttonsStyling: !1,
                        });
                    }
                });
            })
            $('#customizer-form').change(function () {
                let collapseSidebarSwitch = $('#collapse-sidebar-switch').prop("checked");
                let iconAnimationSwitch = $('#icon-animation-switch').prop("checked");
                let cardShadowSwitch = $('#card-shadow-switch').prop("checked");
                let hideScrollTopSwitch = $('#hide-scroll-top-switch').prop("checked");
                navbarColors = $('#customizer-navbar-colors .color-box.selected').data('navbar-color');
                let layoutOptions = $('input[name="layoutOptions"]:checked').data('layout');
                let navbarType = $('input[name="navbarType"]:checked').attr('id');
                let footerType = $('input[name="footerType"]:checked').attr('id');
                shop.ajax_popup('user/customizer', 'POST', {
                    'collapseSidebarSwitch': collapseSidebarSwitch,
                    'iconAnimationSwitch': iconAnimationSwitch,
                    'cardShadowSwitch': cardShadowSwitch,
                    'hideScrollTopSwitch': hideScrollTopSwitch,
                    'layoutOptions': layoutOptions,
                    'navbarColors': navbarColors,
                    'navbarType': navbarType,
                    'footerType': footerType,
                }, function(json){
                    if(json.error == 1) {
                        Swal.fire({
                            title: 'Oops!',
                            text: json.msg,
                            type: "warning",
                            showCancelButton: !0,
                            showConfirmButton: 0,
                            cancelButtonColor: "#d33",
                            cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                            buttonsStyling: !1,
                        });
                    }
                });
            })
        }
        $('textarea.seo').each(function () {
                $(this).val($(this).val().trim());
            }
        );
        $('.switchery').on('click', function() {
            let $ele = $(this).siblings('input[data-plugin="switchery"]');
            if($ele.prop("checked")) {
                $ele.parent('.switchery-demo').attr('title', "Đang hiển thị")
            }else {
                $ele.parent('.switchery-demo').attr('title', "Đang ẩn")
            }
            shop.admin.updateStatus('{{ @$key }}', $ele.data('id'), $ele.prop("checked"), $ele.data('type'))
        })
        $.each($('input[data-plugin="switchery"]'), function (i, e) {
            $ele = $(this);
            if($ele.prop("checked")) {
                $ele.parent('.switchery-demo').attr('title', "Đang hiển thị")
            }else {
                $ele.parent('.switchery-demo').attr('title', "Đang ẩn")
            }
        })

    });
    function SHOW_POPUP_LINK(link, title = 'Xóa bản ghi', msg) {
        Swal.fire({
            title: title,
            text: msg,
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonClass: "btn btn-success mt-2 btn-sm",
            cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
            buttonsStyling: !1,
            confirmButtonText: "Vâng, tôi muốn"
        }).then(function (t) {
            if (t.value) {
                window.location.href = link;
            }
        });
    }
    function SHOW_POPUP_PREVIEW(type, id) {
        shop.ajax_popup(type+'/popup-preview', 'POST', {
            id: id,
        }, function (json) {
            if (json.error == 1) {
                Swal.fire({
                    title: 'Oops!',
                    text: json.msg,
                    type: "warning",
                    showCancelButton: !0,
                    showConfirmButton: 0,
                    cancelButtonColor: "#d33",
                    cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                    buttonsStyling: !1,
                });
            }else {
                $('.preview').empty().html(json);
                $('.bs-example-modal-center').modal({backdrop: 'static'});
                $('.switchery-popup').each(function (idx, obj) {
                    new Switchery($(this)[0], $(this).data());
                });
            }
        }, 'html');
    }

    Vue.directive('select2', {
        inserted: function (el, binding, vnode) {
            /*let options = binding.value || {};
            console.log(options)*/

            $(el).on("select2:select", (e) => {
                el.dispatchEvent(new Event('change', { target: e.target }));
            });
        },
        update: function(el, binding, vnode) {
            $(el).trigger("change");
        }
    });
</script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>