@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
    <div class="row">
        <div class="col-sm-12">
            {!! Form::open(['url' => route('admin.'.$key.'.edit.post', $data->id), 'files' => true]) !!}

            <div class="card">
                <div class="card-header">
                    <i class="fe-menu"></i>Tác giả : {{ @$data->customer_name }}
                </div>
                <div class="card-header">
                    <i class="fe-menu"></i>Nội dung : {{ @$data->comment }}
                </div>
                <div class="card-body">
                   
                    <input type="hidden" name="customer_name" value="{{ @$data->customer_name }}">
                    <input type="hidden" name="phone" value="{{ @$data->phone }}">
                    <input type="hidden" name="url" value="{{ @$data->url }}">
                    <input type="hidden" name="id" value="{{ @$data->id }}">
                    <input type="hidden" name="aid" value="{{ @$data->aid }}">
                    <input type="hidden" name="type_id" value="{{ @$data->type_id }}">
                    <input type="hidden" name="tableName" value="{{ @$data->tableName }}">
                    <input type="hidden" name="comment_parent" value="{{ @$data->comment_parent ? $data->comment_parent : @$data->id }}">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="comment">Trả lời bình luận</label>
                                <textarea name="comment" class="w-100" rows="6">{{ @$data->uid != 0 ? $data->comment : ''   }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Cập nhật</button>
                &nbsp;&nbsp;
                <a class="btn btn-sm btn-danger" href="{{ redirect()->back()->getTargetUrl() }}"><i class="fa fa-ban"></i> Hủy bỏ</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    {!! \Lib::addMedia('admin/js/library/tag/jquery.tag-editor.css') !!}
    {!! \Lib::addMedia('admin/js/library/uploadifive/uploadifive.css') !!}
@stop

@section('js_bot')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    {!! \Lib::addMedia('admin/js/library/uploadifive/jquery.uploadifive.min.js') !!}
    {!! \Lib::addMedia('admin/js/library/uploadifive/multiupload.js') !!}
    {!! \Lib::addMedia('admin/js/library/ckeditor/ckeditor.js') !!}
    {!! \Lib::addMedia('admin/js/library/tag/jquery.caret.min.js') !!}
    {!! \Lib::addMedia('admin/js/library/tag/jquery.tag-editor.min.js') !!}
    <script>
        $(".cate").select2({
            tags: true,
        });
        $("#cat_id").select2();
        shop.getMenu = function (type, lang, def) {
            var html = '<option value="0">-- Chọn --</option>';
            shop.ajax_popup('menu/get-menu', 'POST', {type:type, lang:lang}, function(json) {
                $.each(json.data,function (ind,value) {
                    html += '<option value="'+value.id+'"'+(def == value.id?' selected':'')+'>'+value.title+'</option>';
                    if(value.sub.length != 0){
                        $.each(value.sub,function (k,sub) {
                            html += '<option value="'+sub.id+'"'+(def == sub.id?' selected':'')+'> &nbsp;&nbsp;&nbsp; '+sub.title+'</option>';
                        });
                    }
                });
                $('#pid').html(html);
            });
        };
        shop.multiupload('body');
        @if(\Lib::can($permission, 'filter'))
            shop.admin.filters.init(1, '#filter', 0);
        @endif
    </script>
@stop