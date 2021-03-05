<section id="card-actions">
    @if(old_blade('editMode'))
        @php($obj = $data)
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')), 'class' => 'row', 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'class' => 'row', 'files' => true]) !!}
    @endif
    <div class="row">
        <div class="col-lg-8 col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin chi tiết </h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                @include('forms/input-group-text',['placeholder'=>'Nhập tiêu đề menu...',
                                'field'=>[
                                'label'=>'Tiêu đề menu', 'key'=>'title', 'class' => 'placement', 'name'=>'title',
                                'attr' => [
                                ['key' => 'maxlength', 'value' => '255'],
                                ['key' => 'required', 'value' => 'required'],
                                ]
                                ],
                                ])
                            </div>
                            <div class="col-sm-12">
                                @include('forms/input-group-text',['placeholder'=>'Nhập alias menu...',
                                'field'=>[
                                'label'=>'Route (Không tự ý sửa)', 'key'=>'alias', 'class' => 'placement', 'name'=>'alias',
                                'attr' => [
                                // ['key' => 'maxlength', 'value' => '255'],
                                // ['key' => 'required', 'value' => 'required'],
                                ]
                                ],
                                ])
                            </div>
{{--                            <div class="col-sm-12">--}}
{{--                                @include('forms/input-group-text',['placeholder'=>'Nhập liên kết tĩnh...',--}}
{{--                                'field'=>[--}}
{{--                                'label'=>'Liên kết tĩnh', 'key'=>'link', 'class' => 'placement', 'name'=>'link',--}}
{{--                                'attr' => [--}}
{{--                                ['key' => 'maxlength', 'value' => '255'],--}}
{{--                                ]--}}
{{--                                ],--}}
{{--                                ])--}}
{{--                            </div>--}}
                        
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="type">Loại Menu</label>
                                    <select id="type" name="type" data-toggle="select2" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" onchange="shop.getMenu(this.value, $('#lang').val())">
                                        <option value="-1">-- Chọn --</option>
                                        @foreach($allType as $k => $v)
                                            <option value="{{ $k }}" @if(old('type', @$data->type) == $k) selected="selected" @endif>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pid">Menu cha</label>
                                    <select id="pid" name="pid" data-toggle="select2" class="form-control{{ $errors->has('pid') ? ' is-invalid' : '' }}">
                                        <option value="0">Chưa lựa chọn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-0">
                                    <label for="typeObj">Đối tượng áp dụng</label>
                                    <select id="typeObj" name="type_obj" data-toggle="select2" class="form-control{{ $errors->has('type_obj') ? ' is-invalid' : '' }}">
                                        <option value="0">Chưa lựa chọn</option>
                                        @foreach($allOid as $k => $v)
                                            <option value="{{ $k }}" @if(old('type_obj', @$obj->type_obj) == $k) selected="selected" @endif>{{ $v['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="oid"></label>
                                    <select id="oid" name="oid" data-toggle="select2" class="form-control{{ $errors->has('oid') ? ' is-invalid' : '' }}">
                                        <option value="0">Chưa lựa chọn</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                @include('forms/input-group-text',['placeholder'=>'Nhập số thứ tự mà bạn muốn',
                                'field'=>[
                                'type' => 'number',
                                'label'=>'Sắp xếp', 'key'=>'sort', 'name'=>'sort',
                                ],
                                ])
                            </div>
                            <div class="col-sm-6">
                                @include('forms/input-group-text',['placeholder'=>'Icon Class',
                                'field'=>[
                                'label'=>'Icon Class', 'key'=>'icon', 'name'=>'icon',
                                ],
                                ])
                                @php($list_icon  = explode(",", $config['list_font_awesome']))
                                <div class="childer_icon hidden">
                                            @foreach($list_icon as $item)
                                                @php($class = str_replace( array('"') ,'', $item))
                                                        <div class="icon-box-inner">
                                                            <div class="icon-base">
                                                                <i id="ids-icon" class="{{$class}}"> </i>
                                                            </div>
                                                        </div>
                                            @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @include('forms/input-group-textarea',['placeholder'=>'Nội dung mô tả','field'=>['label'=>"Mô tả ngắn ",'key'=>'description', 'class' => 'seo', 'name'=>'description']])
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div id="addLine">
                @if(@$obj['id'])
                    @if($obj['removed'] == 0)
                        <div class="card">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a href="#thong-tin-bo-sung" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        SEO
                                    </a>
                                </li>
                            </ul>
                            <div class="card-body">
                                <div class="tab-content pt-0">
                                    @if($obj['removed'] == 0)
                                        <div class="tab-pane show active" id="thong-tin-bo-sung">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="image_seo">Ảnh seo</label>
                                                        <input type="file" class="dropify" data-default-file="{{ isset($obj) ? $obj->getImageSeoUrl('original') : '' }}" name="image_seo"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row searching">
                                                <div class="col-md-12">
                                                    @include('forms/input-group-text',[
                                                    'placeholder'=>'Tiêu đề seo','field'=>[
                                                    'label'=>'Tiêu đề seo','name'=>'title_seo', 'key'=>'title_seo', 'class' => 'placement',
                                                    'attr' => [
                                                    ['key' => 'maxlength', 'value' => '160'],
                                                    ]
                                                    ],
                                                    ])
                                                </div>
                                                <div class="col-md-12">
                                                    @include('forms/input-group-textarea',[
                                                    'field'=>[
                                                    'label'=>'Từ khóa','name'=>'keywords', 'key'=>'keywords', 'class'=>'seo', 'note' => 'Mỗi từ khóa cách nhau bởi dấu phẩy', 'classNote' => 'text-warning d-block',
                                                    ],
                                                    ])

                                                </div>
                                                <div class="col-md-12">
                                                    @include('forms/input-group-textarea',[
                                                    'placeholder'=>'Mô tả seo ở đây','field'=>[
                                                    'label'=>'Mô tả seo','name'=>'description_seo', 'class'=>'seo placement', 'key'=>'description_seo', 'id' => 'textarea', 'note' => '*', 'classNote' => 'text-warning',
                                                    'attr' => [
                                                    ['key' => 'maxlength', 'value' => '160'],
                                                    ]
                                                    ],
                                                    ])
                                                </div>
                                                <div class="col-md-12">
                                                    @include('forms/input-group-select',[
                                                    'data' => (@$obj->robots) ? @$obj->robots : 1,
                                                    'field'=>[
                                                    'label'=>'Robots','name'=>'robots', 'key'=>'robots', 'id' => 'robots', 'note' => '*', 'classNote' => 'text-warning',
                                                    'options'=> \Lib::robotSEO(),
                                                    ]])
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a href="#thong-tin-bo-sung" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    SEO
                                </a>
                            </li>
                        </ul>
                        <div class="card-body">
                            <div class="tab-content pt-0">
                                <div class="tab-pane show active" id="seo">
                                    <div class="row">
                                        @include('forms/seo-group')
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bottom-control">
        <div class="container-fluid control-item">
            @if(@$obj['id'] && \Lib::can($permission, 'delete'))
                @if($obj['removed'] == 1)
                    <a href="javascript:void(0)"
                       onclick="shop.admin.revertItem({{ $obj['id'] }}, true, 'menu')"
                       class="btn btn-warning waves-effect btn-xs mr-3"><i class="fe-refresh-cw"></i> Khôi phục</a>
                @else
                    <a href="javascript:void(0)"
                       onclick="shop.admin.revertItem({{ $obj['id'] }}, false, 'menu')"
                       class="btn btn-danger waves-effect btn-xs mr-3"><i class="fe-delete"></i> Xóa</a>
                @endif
            @endif

            @if($view=='popup')
                <a onclick="_CLOSE_MODAL()" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>

                @if( @$obj['id'])
                    <a href="{!! admin_link('/spk-notification/input?id='.$obj['_id'].'&preview=1') !!}"
                       class="btn btn-light waves-effect mr-3 btn-xs"><i class="fe-eye"></i> Xem chi tiết </a>
                @endif

            @else
                <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>
            @endif
            @if(\Lib::can($permission, 'edit'))
                @if($preview && @$obj['id'])
                    <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id')) }}"
                       class="btn btn-warning waves-effect mr-3"><i class="fe-edit"></i> Sửa thông tin</a>
                @else
                    @if( @$obj['id'])
                        <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id').'?preview=1') }}"
                           class="btn btn-light waves-effect mr-3 btn-xs"><i class="fe-eye"></i> Xem chi tiết </a>
                    @endif
                    <button type="submit"
                            class="btn btn-teal-800 waves-effect waves-light mr-3"><i class="fe-save"></i> Cập nhật</button>
                @endif
            @endif


        </div>
    </div>
    {!! Form::close() !!}
</section>
@push("JS_REGION")
    <script>
        function convertToSlug(Text)
        {
            return Text
                .toLowerCase()
                .replace(/ /g,'-')
                .replace(/[^\w-]+/g,'')
                ;
        }

        $(document).ready(function () {
            $('#obj-title').keyup(function(){
                var key = $(this).val();
                $('#obj-alias').attr('value', convertToSlug(key));
            });

            $('[data-toggle="select2"]').select2();
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong appended.'
                },
                error: {
                    'fileSize': 'The file size is too big (1M max).'
                }
            });

            $(".placement").maxlength({
                alwaysShow: !0,
                placement: "top",
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });
            loadOid($('#typeObj').val(), 'vi', {{ @$data->oid }})
            $('#typeObj').change(function () {
                if($('#typeObj').val() != 0) {
                    $('input[name="link"]').parent().addClass('d-none');
                }else {
                    $('input[name="link"]').parent().removeClass('d-none');
                }
                $('#oid').attr('disabled', true);
                loadOid($(this).val(), 'vi')
            })
            if($('#typeObj').val() != 0) {
                // $('input[name="link"]').parent().addClass('d-none');
            }

            $('.icon-base').click(function () {
                var value = $(this).children().attr('class');
                $('#obj-icon').val(value);
                $('.childer_icon ').addClass('hidden');
            })

            $('#obj-icon').click(function () {
                $('.childer_icon ').toggleClass('hidden');
            })
        });
        function loadOid (type, lang, def) {
            var html = '<option value="0">Chưa lựa chọn</option>';
            if(type != 0) {
                shop.ajax_popup('menu/load-oid', 'POST', {id: type}, function (json) {
                    if (json.error == 0) {
                        $.each(json.data,function (ind,value) {
                            html += '<option value="'+value.id+'"'+(def == value.id?' selected':'')+'>'+value.title+'</option>';
                        });
                        $('#oid').html(html);
                        $('#oid').attr('disabled', false);
                    } else {
                        alert(json.msg);
                    }
                });
            }
        }
    </script>
@endpush
