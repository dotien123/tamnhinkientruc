@extends('BackEnd::layouts.default')
@section('CONTENT_REGION')
    @include('BackEnd::pages.page_intro.include.input-form')
@stop

@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/css/plugins/forms/validation/form-validation.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tags/jquery.tag-editor.css') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.css') !!}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        // var advantages_data = '{!! isset($obj->intro_detail->advantages) ? $obj->intro_detail->advantages = str_replace(array("\\r\\n", "\\r", "\\n"), "", $obj->intro_detail->advantages) : '' !!}';
        var advantages_data = '{!! isset($obj->intro_detail->advantages) ? $obj->intro_detail->advantages = str_replace(array("\\r\\n", "\\r", "\\n","\u0022"), "", $obj->intro_detail->advantages) : '' !!}';
    </script>
@stop

@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/js/intro/intro_handling.js') !!}
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.js') !!}
    {!! \Lib::addMedia('admin/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/js/scripts/navs/navs.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tinymce/jquery.tinymce.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tinymce/tinymce.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tags/jquery.caret.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tags/jquery.tag-editor.min.js') !!}
    <script>
        var news = {!! (old_blade('editMode')) ? json_encode($obj) : json_encode(['title' => (old('title')) ? old('title') : '', 'alias' =>(old('alias')) ? old('alias') : '']) !!};
    </script>
    {!! \Lib::addMedia('admin/js/library/slug.js') !!}
    <script>
        $(document).ready(function () {
            
            $('.dropify').dropify({
                messages: {
                    'default': 'K??o v?? th??? t???p v??o ????y ho???c nh???p chu???t t???i ????y.',
                    'replace': 'K??o v?? th??? ho???c nh???p chu???t ????? thay th???',
                    'remove': 'X??a',
                    'error': 'Xin l???i, c?? g?? ???? kh??ng ????ng t???i ????y.'
                },
                error: {
                    'fileSize': 'The file size is too big (1M max).'
                }
            });
            $("#datetime-datepicker-m-d-Y").flatpickr({
                enableTime: !0,
                dateFormat: "d/m/Y H:i"
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
                    { title: 'N???i dung ???nh b??n tr??i', description: 'N???i dung ???nh b??n tr??i', content: '<p style="text-align: justify;">&nbsp;</p><p><img style="float: right;" src="../../../upload/file/original/mceu-26054385611593689311927-1593689312.png" width="503" height="340" /></p><p style="text-align: justify;">Nh???ng c&acirc;y kem ?????u ti&ecirc;n ???????c l&agrave;m tr&ecirc;n que k???o g???, v&agrave; c&oacute; b???n h????ng v??? bao g???m ?????u xanh, ca cao, c???m v&agrave; d???a. Ng?????i n???m gi??? c&ocirc;ng th???c pha ch??? kem Tr&agrave;ng Ti???n t??? n??m 1961 ?????n n??m 1993 l&agrave; &ocirc;ng Kh&aacute;nh. &Ocirc;ng ???????c h???c l???p l&agrave;m kem m???t th&aacute;ng do ng&agrave;nh ??n u???ng m??? nh??ng &ocirc;ng c&oacute; n??ng khi???u v??? m&oacute;n n&agrave;y. Th??? n&ecirc;n ch??? sau m???t th???i gian ng???n l&agrave;m k??? thu???t, &ocirc;ng ??&atilde; n???m ???????c gu c???a ng?????i H&agrave; N???i, kem kh&ocirc;ng ???????c qu&aacute; ng???t, kh&ocirc;ng qu&aacute; c???ng v&agrave; n???u kem c???m th&igrave; ph???i th??m d???u, kem s&ocirc;c&ocirc;la ph???i c&oacute; v??? h??i ????ng ?????ng c&ograve;n kem s???a ph???i m???m l?????i...</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>' },
                    { title: 'N???i dung ???nh b??n ph???i', description: 'N???i dung ???nh b??n ph???i', content: '<p style="text-align: justify;">&nbsp;</p><p><img style="float: left;" src="../../../upload/file/original/mceu-26054385611593689311927-1593689312.png" width="503" height="340" /></p><p style="text-align: justify;">Nh???ng c&acirc;y kem ?????u ti&ecirc;n ???????c l&agrave;m tr&ecirc;n que k???o g???, v&agrave; c&oacute; b???n h????ng v??? bao g???m ?????u xanh, ca cao, c???m v&agrave; d???a. Ng?????i n???m gi??? c&ocirc;ng th???c pha ch??? kem Tr&agrave;ng Ti???n t??? n??m 1961 ?????n n??m 1993 l&agrave; &ocirc;ng Kh&aacute;nh. &Ocirc;ng ???????c h???c l???p l&agrave;m kem m???t th&aacute;ng do ng&agrave;nh ??n u???ng m??? nh??ng &ocirc;ng c&oacute; n??ng khi???u v??? m&oacute;n n&agrave;y. Th??? n&ecirc;n ch??? sau m???t th???i gian ng???n l&agrave;m k??? thu???t, &ocirc;ng ??&atilde; n???m ???????c gu c???a ng?????i H&agrave; N???i, kem kh&ocirc;ng ???????c qu&aacute; ng???t, kh&ocirc;ng qu&aacute; c???ng v&agrave; n???u kem c???m th&igrave; ph???i th??m d???u, kem s&ocirc;c&ocirc;la ph???i c&oacute; v??? h??i ????ng ?????ng c&ograve;n kem s???a ph???i m???m l?????i...</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>' }
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

            tinymce.init({
                selector: 'textarea#des_content',
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
                    { title: 'N???i dung ???nh b??n tr??i', description: 'N???i dung ???nh b??n tr??i', content: '<p style="text-align: justify;">&nbsp;</p><p><img style="float: right;" src="../../../upload/file/original/mceu-26054385611593689311927-1593689312.png" width="503" height="340" /></p><p style="text-align: justify;">Nh???ng c&acirc;y kem ?????u ti&ecirc;n ???????c l&agrave;m tr&ecirc;n que k???o g???, v&agrave; c&oacute; b???n h????ng v??? bao g???m ?????u xanh, ca cao, c???m v&agrave; d???a. Ng?????i n???m gi??? c&ocirc;ng th???c pha ch??? kem Tr&agrave;ng Ti???n t??? n??m 1961 ?????n n??m 1993 l&agrave; &ocirc;ng Kh&aacute;nh. &Ocirc;ng ???????c h???c l???p l&agrave;m kem m???t th&aacute;ng do ng&agrave;nh ??n u???ng m??? nh??ng &ocirc;ng c&oacute; n??ng khi???u v??? m&oacute;n n&agrave;y. Th??? n&ecirc;n ch??? sau m???t th???i gian ng???n l&agrave;m k??? thu???t, &ocirc;ng ??&atilde; n???m ???????c gu c???a ng?????i H&agrave; N???i, kem kh&ocirc;ng ???????c qu&aacute; ng???t, kh&ocirc;ng qu&aacute; c???ng v&agrave; n???u kem c???m th&igrave; ph???i th??m d???u, kem s&ocirc;c&ocirc;la ph???i c&oacute; v??? h??i ????ng ?????ng c&ograve;n kem s???a ph???i m???m l?????i...</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>' },
                    { title: 'N???i dung ???nh b??n ph???i', description: 'N???i dung ???nh b??n ph???i', content: '<p style="text-align: justify;">&nbsp;</p><p><img style="float: left;" src="../../../upload/file/original/mceu-26054385611593689311927-1593689312.png" width="503" height="340" /></p><p style="text-align: justify;">Nh???ng c&acirc;y kem ?????u ti&ecirc;n ???????c l&agrave;m tr&ecirc;n que k???o g???, v&agrave; c&oacute; b???n h????ng v??? bao g???m ?????u xanh, ca cao, c???m v&agrave; d???a. Ng?????i n???m gi??? c&ocirc;ng th???c pha ch??? kem Tr&agrave;ng Ti???n t??? n??m 1961 ?????n n??m 1993 l&agrave; &ocirc;ng Kh&aacute;nh. &Ocirc;ng ???????c h???c l???p l&agrave;m kem m???t th&aacute;ng do ng&agrave;nh ??n u???ng m??? nh??ng &ocirc;ng c&oacute; n??ng khi???u v??? m&oacute;n n&agrave;y. Th??? n&ecirc;n ch??? sau m???t th???i gian ng???n l&agrave;m k??? thu???t, &ocirc;ng ??&atilde; n???m ???????c gu c???a ng?????i H&agrave; N???i, kem kh&ocirc;ng ???????c qu&aacute; ng???t, kh&ocirc;ng qu&aacute; c???ng v&agrave; n???u kem c???m th&igrave; ph???i th??m d???u, kem s&ocirc;c&ocirc;la ph???i c&oacute; v??? h??i ????ng ?????ng c&ograve;n kem s???a ph???i m???m l?????i...</p><p style="text-align: justify;">&nbsp;</p><p style="text-align: justify;">&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>' }
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
        });
    </script>
@endpush
