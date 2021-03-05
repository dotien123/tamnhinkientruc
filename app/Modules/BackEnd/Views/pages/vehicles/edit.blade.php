@extends('BackEnd::layouts.default')
@section('CONTENT_REGION')
    @include('BackEnd::pages.'.$key.'.include.input-form')
@stop
@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/css/plugins/forms/validation/form-validation.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tags/jquery.tag-editor.css') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.css') !!}
    <style>
        .childer_icon{
            height: 89px;overflow: scroll;float: left; width: 100%
        }
        .childer_icon .icon-box-inner{
            float: left;
            width:8%;
            margin:1px 1px;
            text-align: center;
            height: 25px;
            line-height: 25px;
            border: 1px  #000;
            background: #dbe2e2;
            cursor: pointer;
        }
    </style>
@stop

@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.js') !!}
    {!! \Lib::addMedia('admin/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/js/scripts/navs/navs.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tinymce/jquery.tinymce.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tinymce/tinymce.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tags/jquery.caret.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tags/jquery.tag-editor.min.js') !!}
    <script type="text/javascript">
        shop.ready.add(function(){
            $('[data-toggle="select2"]').select2();
            shop.getCat($('#type').val(), $('#lang').val(), {{ @$obj->pid }});
        },true);
        shop.getCat = function (type, lang, def) {
            var html = '<option value="0">Chưa lựa chọn</option>';
            shop.ajax_popup('category/get-cat', 'POST', {type:type, lang:lang}, function(json) {
                $.each(json.data,function (ind,value) {
                    html += '<option value="'+value.id+'"'+(def == value.id?' selected':'')+'>'+value.title+'</option>';
                    if(value.sub.length != 0){
                        $.each(value.sub,function (k,sub) {
                            html += '<option value="'+sub.id+'"'+(def == sub.id?' selected':'')+'> ---- '+sub.title+'</option>';
                        });
                    }
                });
                $('#pid').html(html);
                // show-hidde position cate
                if(type == 1){
                    $('#position_product').removeClass('hidden');
                    $('#position_product').addClass('show');
                }else{
                    $('#position_product').addClass('hidden');
                    $('#position_product').removeClass('show');
                }
            });
        };
    </script>
@endpush