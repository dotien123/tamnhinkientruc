<section id="card-actions">
    @if(old_blade('editMode'))
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')), 'class' => 'row', 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'class' => 'row', 'files' => true]) !!}
    @endif
    <div class="row" style="width:100%">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin chi tiết </h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @include('forms/input-group-radio-checked',[
                                'type'=>'radio', 'field'=>[
                                'label'=>'Ẩn hiện menu trái', 'name' => 'is_home',
                                'obj' => [
                                ['id' => 'publish','class' => 'form-check-inline radio-success', 'key' =>
                                'is_home', 'label' => 'Hiện', 'value' => \App\Models\News::STATUS_ACTIVE],
                                ['id' => 'pending','class' => 'form-check-inline radio-warning', 'key' =>
                                'is_home', 'label' => 'Ẩn', 'value' =>\App\Models\News::STATUS_INACTIVE],
                                ]
                                ],
                                'data' => @$obj->is_home
                                ])
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        @include('forms/input-group-text',['placeholder'=>'Nhập tiêu đề phụ tùng...',
                                        'field'=>[
                                        'label'=>'Tiêu đề phụ tùng', 'key'=>'title', 'class' => 'placement', 'name'=>'title', 'note' => '*', 'classNote' => 'text-danger',
                                        'attr' => [
                                        ['key' => 'maxlength', 'value' => '255'],
                                        ['key' => 'v-model', 'value' => 'input'],
                                        ['key' => 'required', 'value' => 'required'],
                                        ]
                                        ],
                                        ])
                                    </div>
                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
        $(document).ready(function () {
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

        // checkbox
        $(document).ready(function () {
            if($('#checkboxfae_home').is(':checked')) {
                $('#childe_home').removeClass('hidden');
                $('#childe_home').addClass('show');
            }
            if($('#checkbox_sidebar').is(':checked')) {
                $('#childe_sidebar').removeClass('hidden');
                $('#childe_sidebar').addClass('show');
            }

            var val_limit_is_home_old = $('#obj-limit_is_home').val();
            var val_limit_issidebar_old = $('#obj-limit_is_sidebar').val();
            //event-click
            $('#checkboxfae_home').click (function ()
            {
                var thisCheck = $(this);
                if (thisCheck.is(':checked'))
                {
                    $('#childe_home').removeClass('hidden');
                    $('#childe_home').addClass('show');
                    if(val_limit_is_home_old != 0){
                        $('#obj-limit_is_home').val(val_limit_is_home_old);
                    }else{
                        $('#obj-limit_is_home').val(5);
                    }

                }else{
                    $('#childe_home').removeClass('show');
                    $('#childe_home').addClass('hidden');
                    //set data =  0 khi not checked
                    $('#obj-limit_is_home').val(0);
                }
            });

            $('#checkbox_sidebar').click (function ()
            {
                var thisCheck = $(this);
                if (thisCheck.is(':checked'))
                {
                    $('#childe_sidebar').removeClass('hidden');
                    $('#childe_sidebar').addClass('show');
                    if(val_limit_issidebar_old != 0){
                        $('#obj-limit_is_sidebar').val(val_limit_issidebar_old);
                    }else{
                        $('#obj-limit_is_sidebar').val(5);
                    }
                }else{
                    $('#childe_sidebar').removeClass('show');
                    $('#childe_sidebar').addClass('hidden');
                    //set data =  0 khi not checked
                    $('#obj-limit_is_sidebar').val(0);
                }
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
        })
    </script>
@endpush
