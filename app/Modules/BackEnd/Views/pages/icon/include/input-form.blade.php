<section id="card-actions">
    @if(old_blade('editMode'))
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')), 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'files' => true]) !!}
    @endif
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card" id="slug-alias">
                <div class="card-header">
                    <h4 class="card-title">Thông tin chi tiết </h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tiêu đề  <span class="text-danger">*</span></label>
                            <input type="text" maxlength="250" autocomplete="off" id="placement" required name="title" value="{{ old('title', @$obj->title) }}" class="form-control" placeholder="tiêu đề ">
                        </div>

                        <div class="form-group">
                            <label for="content">Vị trí</label>
                            <input type="text" maxlength="250" autocomplete="off" id="placement" required name="content" value="{{ old('content', @$obj->content) }}" class="form-control" placeholder="tiêu đề ">
                        </div>

                        <div class="form-group">
                            @include('forms/input-group-textarea',['placeholder'=>'','field'=>['label'=>"Tiểu sử",'key'=>'description', 'class'=>'txt_tinymce', 'name'=>'description']])
                        </div>
                        
                    </div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-6 col-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ảnh</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <input type="file" data-img="{{ @$obj->image }}" class="dropify" @if(@$obj['id']) data-default-file="{{ @$obj->getImageUrl('original', 'image', 'icon') }}" @endif name="image"  />
                    </div>
                    <div class="card-body">
                        @include('forms/input-group-radio-checked',[
                            'type'=>'radio', 'field'=>[
                                'label'=>'Trạng thái', 'name' => 'status',
                                'obj' => [
                                    ['id' => 'publish','class' => 'form-check-inline radio-success', 'key' => 'status', 'label' => 'Đăng ngay', 'value' => \App\Models\Feature::STATUS_ACTIVE],
                                    ['id' => 'pending','class' => 'form-check-inline radio-warning', 'key' => 'status', 'label' => 'Chờ xét duyệt', 'value' => \App\Models\Feature::STATUS_INACTIVE],
                                ]
                            ],
                            'data' => @$obj->status
                        ])
                    </div>
                </div>
            </div>
        </div> <!-- end col-->
    </div>

    <div class="bottom-control">
        <div class="container-fluid control-item">

            @if($view=='popup')
                <a onclick="_CLOSE_MODAL()" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>
            @else
                <a href="{{ route('admin.'.$key) }}" class="btn btn-light btn-xs mr-3">Bỏ qua</a>
            @endif
            @if(\Lib::can($permission, 'edit'))
                    <button type="submit"
                            class="btn btn-teal-800 waves-effect waves-light mr-3"><i class="fe-save"></i> Cập nhật</button>
            @endif

        </div>
    </div>
    {!! Form::close() !!}
    <input type="hidden" id="id_removeimage" value="{{ @$obj['id'] }}">
</section>
@push("JS_REGION")
    <script>
        
        $(document).ready(function () {
            jQuery('[name="obj[type][id]"]').change(function (e) {
                getLastestDocument(e.target)
            });

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

            $("input.placement").maxlength({
                alwaysShow: !0,
                placement: "top-left",
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });

            shop.admin.summernote.init('#content', 500);
        
        });

    </script>
     <script>
        $(document).ready(function() {

            $('textarea#textarea').maxlength({
                alwaysShow: true,
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });
            tinymce.init({
                selector: 'textarea.txt_tinymce',
                setup: function(editor) {
                    editor.on('change', function() {
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
            $('input[name="layoutOptions"]').on('click change', function() {
                if ($('input[name="layoutOptions"]:checked').data('layout') == 'dark-layout') {
                    $('#obj-chinh_sach_doi_tra_ifr').contents().find('#tinymce').addClass('dark-layout')
                    $('#obj-chinh_sach_giao_hang_ifr').contents().find('#tinymce').addClass('dark-layout')
                    $('#obj-description_ifr').contents().find('#tinymce').addClass('dark-layout')
                } else {
                    $('#obj-chinh_sach_doi_tra_ifr').contents().find('#tinymce').removeClass('dark-layout')
                    $('#obj-chinh_sach_giao_hang_ifr').contents().find('#tinymce').removeClass(
                        'dark-layout')
                    $('#obj-description_ifr').contents().find('#tinymce').removeClass('dark-layout')
                }
            });
        });
       
    </script>
    <script>
        $(document).ready(function(){
            $('.dropify-clear').click(function(){
                var img = $('.dropify').attr('data-img');
                var id = $('#id_removeimage').val();
                shop.ajax_popup('icon/removeimg', 'POST', {img:img, id:id}, function(img) {});
            });
        })
    </script>

@endpush