<section id="card-actions">
    @if(old_blade('editMode'))
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')), 'class' => 'row', 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'class' => 'row', 'files' => true]) !!}
    @endif
    <div class="row" style="width: 100%">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin chi tiết </h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12   ">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        @include('forms/input-group-text',['placeholder'=>'Nhập tên khoảng giá sản phẩm...',
                                        'field'=>[
                                            'label'=>'Tên khoảng giá', 'key'=>'title', 'class' => 'placement', 'name'=>'title', 'note' => '*', 'classNote' => 'text-danger',
                                            'attr' => [
                                               ['key' => 'maxlength', 'value' => '255'],
                                               ['key' => 'required', 'value' => 'required'],
                                               ['key' => 'data-validation-required-message', 'value' => 'Tên khoảng giá sản phẩm không được để trống.'],
                                            ]
                                        ],
                                    ])
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="tt">Chọn mục</label>
                                            <select id="type" name="type" class="form-control">
                                                <option value="0" {{ @$obj->type == 0 ? 'selected' : '' }}>Sản phẩm</option>
                                                <option value="1" {{ @$obj->type == 1 ? 'selected' : '' }}>Phụ tùng</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- <div class="col-12 col-lg-6">
                                        @include('forms/input-group-text',['placeholder'=>'Nhập khoảng giá từ...',
                                            'field'=>[
                                                'label'=>'Khoảng giá từ', 'key'=>'price_to', 'name'=>'price_to', 'note' => '', 'classNote' => 'text-danger',
                                                'attr' => [
                                                    ['key' => 'data-type', 'value' => 'currency'],
                                                    ['key' => 'required', 'value' => 'required'],
                                                    ['key' => 'data-validation-required-message', 'value' => 'Giá bán không được để trống.'],
                                                ]
                                            ],
                                        ])
                                    </div>
    
                                    <div class="col-12 col-lg-6">
                                        @include('forms/input-group-text',['placeholder'=>'Nhập khoảng giá đến...',
                                            'field'=>[
                                                'label'=>'Khoảng giá đến', 'key'=>'price_from', 'name'=>'price_from', 'note' => '', 'classNote' => 'text-danger',
                                                'attr' => [
                                                    ['key' => 'data-type', 'value' => 'currency'],
                                                    ['key' => 'data-validation-required-message', 'value' => 'Giá đến không được để trống.'],
                                                ]
                                            ],
                                        ])
                                    </div> --}}
                                   
                                    
                                </div>
                            </div>
                            {{-- <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="image">Ảnh đại diện</label>
                                    <input type="file" class="dropify" data-default-file="{{ isset($obj) ? $obj->getImageUrl('original') : '' }}" name="image"  />
                                </div>
                            </div>
                            <div class="col-md-12">
                                      
                                @include('forms/input-group-textarea',['field'=>['label'=>"Nội dung chính ",'key'=>'content', 'id' => 'content', 'name'=>'content',]])
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-12 col-lg-4">
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
                                                        <input type="file" class="dropify" data-default-file="{{ isset($obj) ? $obj->getImageSeoUrl('image_seo', 'status', 'original') : '' }}" name="image_seo"  />
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
        </div> --}}
    </div>
    <div class="bottom-control">
        <div class="container-fluid control-item">
           

            @if($view=='popup')
                <a onclick="_CLOSE_MODAL()" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>

                @if( @$obj['id'])
                    <a href="{!! admin_link('/spk-notification/input?id='.$obj['_id'].'&preview=1') !!}"
                       class="btn btn-light waves-effect mr-3 btn-xs"><i class="fe-eye"></i> Xem chi tiết </a>
                @endif

            @else
                <a href="{{ route('admin.'.$key) }}" class="btn btn-light btn-xs mr-3">Bỏ qua</a>
            @endif

            @if(\Lib::can($permission, 'edit'))
                @if($preview && @$obj['id'])
                    <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id')) }}"
                       class="btn btn-warning waves-effect mr-3"><i class="fe-edit"></i> Sửa thông tin</a>
                @else

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

        function formatNumber(n) {
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function formatCurrency(input, blur) {
        var input_val = input.val();
        if (input_val === "") { return; }
        var original_len = input_val.length;
        var caret_pos = input.prop("selectionStart");
        if (input_val.indexOf(".") >= 0) {
            var decimal_pos = input_val.indexOf(".");
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            left_side = formatNumber(left_side);
            right_side = formatNumber(right_side);
            if (blur === "blur") {
            right_side += "00";
            }
            right_side = right_side.substring(0, 2);
            input_val =  left_side + "." + right_side + "VNĐ";
        } else {
            input_val = formatNumber(input_val);
            input_val = input_val + " VNĐ";
            if (blur === "blur") {
            input_val += ".00";
            }
        }
        input.val(input_val);

        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
        }

        $(document).ready(function () {
            
            $("#obj-title").keyup(function() {
                var title = $(this).val();
                if(title == 'lien he' || title == 'Liên Hệ' || title == 'liên hệ' || title == 'Liên hệ') 
                {
                    $("input[data-type='currency']").attr('value',0);
                }
            });


            $("input[data-type='currency']").on({
                keyup: function() {
                formatCurrency($(this));
                },
                blur: function() { 
                formatCurrency($(this), "blur");
                }
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
                $('input[name="link"]').parent().addClass('d-none');
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
                        console.log(json.msg);
// alert(json.msg);
                    }
                });
            }
        }

       
    </script>
@endpush
