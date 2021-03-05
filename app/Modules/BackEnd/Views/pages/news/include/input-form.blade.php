<!-- card actions section start -->
<section id="card-actions">
    <!-- form starts -->
    @if(old_blade('editMode'))
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')), 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'files' => true]) !!}
    @endif
        <!-- row -->
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin chi tiết </h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row" id="slug-alias">
                                <div class="col-sm-12">
                                    @include('forms/input-group-text',['placeholder'=>'Nhập tiêu đề bài viết...',
                                        'field'=>[
                                            'label'=>'Tiêu đề bài viết', 'key'=>'title', 'class' => 'placement', 'name'=>'title', 'note' => '*', 'classNote' => 'text-danger',
                                            'attr' => [
                                               ['key' => 'maxlength', 'value' => '255'],
                                               ['key' => 'v-model', 'value' => 'input'],
                                               ['key' => 'required', 'value' => 'required'],
                                            ]
                                        ],
                                    ])
                                </div>

                                {{-- <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <strong>Liên kết tĩnh &nbsp;</strong> 
                                            @if(old_blade('editMode'))
                                            <span id="sample-permalink" class="fs-13">
                                                <a href="{{ route('news.detail',['alias' => @$obj->alias,'id' => $obj->id]) }}" target="_blank"> {{ route('news.detail',['alias' => @$obj->alias,'id' => $obj->id]) }}</a>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="input-group">
                                            <input value="{{@$obj->alias}}" type="text" name="alias" class="form-control th-service text-blue" id="basic-url" aria-describedby="basic-addon3" placeholder="Liên kết tĩnh">
                                        </div>
                                    </div>
                                </div> --}}

                                
                                <div class="col-sm-12">
                                    @include('forms/input-group-text',['placeholder'=>'Nhập tác giả...',
                                        'field'=>[
                                            'label'=>'Tác giả', 'key'=>'source', 'class' => 'form-control', 'name'=>'source', 'classNote' => 'text-danger',
                                            'attr' => [
                                            //    ['key' => 'maxlength', 'value' => '255'],
                                            //    ['key' => 'v-model', 'value' => 'input'],
                                            //    ['key' => 'required', 'value' => 'required'],
                                            ]
                                        ],
                                    ])
                                </div>

                                <div class="col-sm-12">
                                    @include('forms/input-group-text',['placeholder'=>'Nhập nguồn bài viết...',
                                        'field'=>[
                                            'label'=>'Nhập nguồn bài viết', 'key'=>'auths', 'class' => 'form-control', 'name'=>'auths', 'classNote' => 'text-danger',
                                            'attr' => [
                                            //    ['key' => 'maxlength', 'value' => '255'],
                                            //    ['key' => 'v-model', 'value' => 'input'],
                                            //    ['key' => 'required', 'value' => 'required'],
                                            ]
                                        ],
                                    ])
                                </div>
                                
                                
                            </div>

                            <div class="row">
                                {{-- <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        @include('forms/input-group-textarea',['placeholder'=>'Link video','field'=>['label'=>"Link video ",'key'=>'link_video', 'class'=>'seo', 'name'=>'link_videos']])
                                        
                                    </div>
                                </div> --}}
                                <div class="col-3">
                                    @if($preview)
                                        <div class="form-group">
                                            <label >Ảnh đại diện</label>
                                            <img class="col" src="{{ isset($obj) ? $obj->getImageUrl('original') : '' }}" alt="{{ @$obj->title }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    @if(@$preview)
                                        <div class="form-group">
                                            <label >Danh mục cha: &nbsp</label>
                                            <span class="badge badge-primary p-1"> {{ value_show(@$catOpt['_'.@$obj->cate_par]['title'], 'Chưa cập nhật') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Danh mục con: &nbsp</label>
                                            @foreach($obj->categories as $sub)
                                                <span class="badge badge-primary p-1"> {{ value_show($sub['title'], 'Chưa cập nhật') }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    @include('forms/input-group-textarea',['placeholder'=>'Nội dung mô tả','field'=>['label'=>"Mô tả ngắn ",'key'=>'description', 'class'=>'seo', 'name'=>'description']])
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-12">
                                    @include('forms/input-group-textarea',['field'=>['label'=>"Nội dung chính ",'key'=>'content', 'id' => 'content', 'name'=>'content',]])
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                @if(!$preview)
                    <div class="card">

                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a href="#thong-tin-bo-sung" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    Ảnh đại diện
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="#danh-muc-tin" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    Danh mục
                                </a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a href="#seo" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    SEO
                                </a>
                            </li> --}}
                        </ul>
                        <div class="card-body">
                            <div class="tab-content pt-0">
                                <div class="tab-pane show active" id="thong-tin-bo-sung">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="image">Ảnh đại diện</label>
                                                <input type="file" data-img="{{ @$obj->image }}" class="dropify" data-default-file="{{ isset($obj) ? $obj->getImageUrl('image', 'news', 'original') : '' }}" name="image"  />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            @include('forms/input-group-radio-checked',[
                                                'type'=>'radio', 'field'=>[
                                                    'label'=>'Trạng thái', 'name' => 'status',
                                                    'obj' => [
                                                        ['id' => 'publish','class' => 'form-check-inline radio-success', 'key' => 'status', 'label' => 'Đăng ngay', 'value' => \App\Models\Product::STATUS_ACTIVE],
                                                        ['id' => 'pending','class' => 'form-check-inline radio-warning', 'key' => 'status', 'label' => 'Chờ xét duyệt', 'value' => \App\Models\Product::STATUS_INACTIVE],
                                                    ]
                                                ],
                                                'data' => @$obj->status
                                            ])
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col">
                                            @include('forms/input-group-text',[
                                                'placeholder'=>'Ngày xuất bản', 'field'=>[
                                                    'class' => 'datepicker',
                                                    'id' => 'datetime-datepicker-m-d-Y',
                                                    'label'=>'Thời gian hiển thị (mới nhất lên trên)', 'key'=>'published', 'name'=>'published',
                                                    'formatDate' => 'd/m/Y H:i'
                                                ],
                                            ])

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="danh-muc-tin">
                                    {!! $lsCate !!}
                                </div>
                                <div class="tab-pane" id="seo">
                                    <div class="row">
                                        @include('forms/seo-group')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- endrow -->
    <!-- btn-group -->
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
    <!-- btn-group end -->
    {!! Form::close() !!}
    <input type="hidden" id="id_removeimage" value="{{ @$obj->id }}">
    <!-- formEnds -->
</section>
<!-- // card-actions section end -->

@push("JS_REGION")
       


    <script>
        $(document).ready(function () {
            

            $('input.cker').change(function () {
                if(this.checked) {
                    $(this).parent().append('<a href="javascript:void(0);" class="font-13 make ml-2">Make primary</a>')
                }else {
                    $(this).parent().find('a.make').remove()
                }
                $('a.make').click(function () {
                    $('a.make').removeClass('active');
                    $('a.make').parent().find('input[name="cate_primary"]').remove();
                    $(this).addClass('active');
                    let cate_pri = $(this).siblings('input').val();
                    $(this).parent().append('<input type="hidden" name="cate_primary" value="'+cate_pri+'" />')
                });
            });

            $('a.make').click(function () {
                $('a.make').removeClass('active');
                $('a.make').parent().find('input[name="cate_primary"]').remove();
                $(this).addClass('active');
                let cate_pri = $(this).siblings('input').val();
                $(this).parent().append('<input type="hidden" name="cate_primary" value="'+cate_pri+'" />')
            });
            $("#datetime-datepicker-m-d-Y").flatpickr({
                enableTime: !0,
                dateFormat: "d/m/Y H:i"
            });
            $('.dropify').dropify({
                messages: {
                    'default': 'Kéo và thả tệp vào đây hoặc nhấp chuột tại đây.',
                    'replace': 'Kéo và thả hoặc nhấp chuột để thay thế',
                    'remove': 'Xóa',
                    'error': 'Xin lỗi, có gì đó không đúng tại đây.'
                },
                error: {
                    'fileSize': 'The file size is too big (1M max).'
                }
            });

            $("input.placement").maxlength(
                {
                    alwaysShow: !0,
                    placement: "top",
                    warningClass: "badge badge-success",
                    limitReachedClass: "badge badge-danger"
                });
            $('textarea#textarea').maxlength({
                alwaysShow: true,
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });
            tinymce.init({
                selector: 'textarea#content',
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
                    });
                },

                plugins: 'print preview importcss searchreplace autolink save directionality visualblocks visualchars fullscreen image link media template code codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                mobile: {
                    plugins: 'print preview importcss searchreplace autolink save directionality visualblocks visualchars fullscreen image link media template code codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons'
                },
                menubar: 'file edit view insert format tools table tc help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
                image_advtab: true,
                save_enablewhendirty: true,
                images_upload_base_path: '/admin/ajax/file/upload-file',
                images_upload_credentials: true,
                images_upload_handler: function (blobInfo, success, failure) {
                    var xhr, formData;

                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '/admin/ajax/file/upload-file');
                    xhr.setRequestHeader("X-CSRF-Token", jQuery('meta[name=_token]').attr("content"));
                    xhr.onload = function() {
                        var json;
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.data.full_size_link != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(json.data.full_size_link);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                },
                relative_urls: false,
                branding: false,
                link_list: [
                    { title: 'My page 1', value: 'http://www.tinymce.com' },
                    { title: 'My page 2', value: 'http://www.moxiecode.com' }
                ],
                image_list: [
                    { title: 'My page 1', value: 'http://www.tinymce.com' },
                    { title: 'My page 2', value: 'http://www.moxiecode.com' }
                ],
                image_class_list: [
                    { title: 'None', value: '' },
                    { title: 'Some class', value: 'class-name' }
                ],
                importcss_append: true,
                height: 400,
                templates: [
                    { title: 'Nội dung ảnh bên trái', description: 'Nội dung ảnh bên trái', content: '<p style="text-align: justify;">&nbsp;</p><p><img style="float: right;" src="../../../upload/file/original/mceu-26054385611593689311927-1593689312.png" width="503" height="340" /></p><p style="text-align: justify;">Những c&acirc;y kem đầu ti&ecirc;n được l&agrave;m tr&ecirc;n que kẹo gỗ, v&agrave; c&oacute; bốn hương vị bao gồm đậu xanh, ca cao, cốm v&agrave; dừa. Người nắm giữ c&ocirc;ng thức pha chế kem Tr&agrave;ng Tiền từ năm 1961 đến năm 1993 l&agrave; &ocirc;ng Kh&aacute;nh. &Ocirc;ng được học lớp l&agrave;m kem một th&aacute;ng do ng&agrave;nh ăn uống mở nhưng &ocirc;ng c&oacute; năng khiếu về m&oacute;n n&agrave;y. Thế n&ecirc;n chỉ sau một thời gian ngắn l&agrave;m kỹ thuật, &ocirc;ng đ&atilde; nắm được gu của người H&agrave; Nội, kem kh&ocirc;ng được qu&aacute; ngọt, kh&ocirc;ng qu&aacute; cứng v&agrave; nếu kem cốm th&igrave; phải thơm dịu, kem s&ocirc;c&ocirc;la phải c&oacute; vị hơi đăng đắng c&ograve;n kem sữa phải mềm lưỡi...</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>' },
                    { title: 'Nội dung ảnh bên phải', description: 'Nội dung ảnh bên phải', content: '<p style="text-align: justify;">&nbsp;</p><p><img style="float: left;" src="../../../upload/file/original/mceu-26054385611593689311927-1593689312.png" width="503" height="340" /></p><p style="text-align: justify;">Những c&acirc;y kem đầu ti&ecirc;n được l&agrave;m tr&ecirc;n que kẹo gỗ, v&agrave; c&oacute; bốn hương vị bao gồm đậu xanh, ca cao, cốm v&agrave; dừa. Người nắm giữ c&ocirc;ng thức pha chế kem Tr&agrave;ng Tiền từ năm 1961 đến năm 1993 l&agrave; &ocirc;ng Kh&aacute;nh. &Ocirc;ng được học lớp l&agrave;m kem một th&aacute;ng do ng&agrave;nh ăn uống mở nhưng &ocirc;ng c&oacute; năng khiếu về m&oacute;n n&agrave;y. Thế n&ecirc;n chỉ sau một thời gian ngắn l&agrave;m kỹ thuật, &ocirc;ng đ&atilde; nắm được gu của người H&agrave; Nội, kem kh&ocirc;ng được qu&aacute; ngọt, kh&ocirc;ng qu&aacute; cứng v&agrave; nếu kem cốm th&igrave; phải thơm dịu, kem s&ocirc;c&ocirc;la phải c&oacute; vị hơi đăng đắng c&ograve;n kem sữa phải mềm lưỡi...</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>' }
                ],
                template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
                template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
                height: 600,
                image_caption: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: "mceNonEditable",
                toolbar_mode: 'sliding',
                spellchecker_dialog: true,
                spellchecker_whitelist: ['Ephox', 'Moxiecode'],
                content_style: ".mymention{ color: gray; }",
                contextmenu: "link image imagetools table configurepermanentpen",
                a11y_advanced_options: true,
                fontsize_formats: "8px 10px 12px 14px 18px 24px 36px"
            });
            $('input[name="layoutOptions"]').on('click change', function () {
                if($('input[name="layoutOptions"]:checked').data('layout') == 'dark-layout') {
                    $('#content_ifr').contents().find('#tinymce').addClass('dark-layout')
                }else {
                    $('#content_ifr').contents().find('#tinymce').removeClass('dark-layout')
                }
            });
        });
        $(window).bind("load", function() {
            if($('input[name="layoutOptions"]:checked').data('layout') == 'dark-layout') {
                $('#content_ifr').contents().find('#tinymce').addClass('dark-layout')
            }
            $('body').on('mousedown', function () {
                $('.tag-editor').removeClass('tag-editor-focus');

            });
            $('.tag-editor').on('click change',function () {
                $('.tag-editor').addClass('tag-editor-focus');
            })
        });
    </script>

    <script>

        <?php
            echo "var allCateSubject ='" . json_encode($catOpt) . "';";
            echo "var allCateEditChecked ='" . json_encode(@$obj['categories']) . "';";
        ?>
        allCateSubject = JSON.parse(allCateSubject);
        allCateEditChecked = JSON.parse(allCateEditChecked);

        function showSubjectCateByRootSubject(parents) {
            var html = '<div class="row">';
            if (typeof allCateSubject['_'+parents] !== 'undefined') {

                for (var i in allCateSubject['_'+parents]['sub']) {
                    var alias = allCateSubject['_'+parents]['sub'][i];
                    if (typeof alias != 'undefined') {
                        //console.log(allCateSubject['items'][alias]['name'])
                        var name = alias['title'];
                        var _id = alias['id'];
                        html += '<div class="checkbox checkbox-info mb-2 ml-1 col-md-6"><input type="checkbox"';
                        /*if(allCateEditChecked != null && typeof allCateEditChecked[_id] !== 'undefined') {
                            console.log( allCateEditChecked[_id]);
                            html += 'checked';
                        }*/
                        html += ' name="cate[' + _id + ']" id="check_child_' + _id + '" value="' + _id + '"/><label for="check_child_'+ _id + '"> ' + name + '</label>';
                        html += '</div>';
                    }

                }
            }
            html += '</div>';
            //document.getElementById('inputCateCheckBoxRegion').innerHTML = html;
            jQuery('#inputCateCheckBoxRegion').html(html);

        }

        shop.ready.add(function(){
            // shop.multiupload('body');
            @if(\Lib::can($permission, 'tag'))
            shop.admin.tags.init({{ $tagType }}, '#tags', {{ @$obj->id }});
            @endif;


        }, true);

    </script>
    <script>
        $(document).ready(function(){
            $('.dropify-clear').click(function(){
                var img = $('.dropify').attr('data-img');
                var id = $('#id_removeimage').val();
                shop.ajax_popup('news/removeimg', 'POST', {img:img, id:id}, function(img) {});
            });
        })
    </script>
@endpush