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
                        <div class="row">
                            <div class="col-sm-12">
                                @include('forms/input-group-text',['placeholder'=>'Nhập tên cửa hàng...',
                                    'field'=>[
                                        'label'=>'Tiêu đề bài viết', 'key'=>'name_store', 'class' => 'placement', 'name'=>'name_store', 'note' => '*', 'classNote' => 'text-danger',
                                        'attr' => [
                                           ['key' => 'maxlength', 'value' => '255'],
                                           ['key' => 'required', 'value' => 'required'],
                                        ]
                                    ],
                                ])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @include('forms/input-group-text',['placeholder'=>'Nhập địa chỉ cửa hàng...',
                                    'field'=>[
                                        'label'=>'Địa chỉ cửa hàng', 'key'=>'address', 'class' => 'placement', 'name'=>'address', 'note' => '*', 'classNote' => 'text-danger',
                                        'attr' => [
                                           ['key' => 'maxlength', 'value' => '255'],
                                           ['key' => 'required', 'value' => 'required'],
                                        ]
                                    ],
                                ])
                            </div>
                        </div>
                        <div>
                            <div class="col-sm-12">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @include('forms/input-group-text',['placeholder'=>'Tọa độ lat...',
                                    'field'=>[
                                        'label'=>'Tọa độ lat', 'key'=>'lat', 'class' => 'placement', 'name'=>'lat', 'note' => '*', 'classNote' => 'text-danger',
                                        'attr' => [
                                           ['key' => 'maxlength', 'value' => '255'],
                                           ['key' => 'required', 'value' => 'required'],
                                        ]
                                    ],
                                ])
                            </div>
                        </div><div class="row">
                            <div class="col-sm-12">
                                @include('forms/input-group-text',['placeholder'=>'Tọa độ long...',
                                    'field'=>[
                                        'label'=>'Tọa độ long', 'key'=>'long', 'class' => 'placement', 'name'=>'long', 'note' => '*', 'classNote' => 'text-danger',
                                        'attr' => [
                                           ['key' => 'maxlength', 'value' => '255'],
                                           ['key' => 'required', 'value' => 'required'],
                                        ]
                                    ],
                                ])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @include('forms/input-group-text',['placeholder'=>'Nhập số điện thoại cửa hàng...',
                                    'field'=>[
                                        'label'=>'Số điện thoại cửa hàng', 'key'=>'phone', 'class' => 'placement', 'name'=>'phone', 
                                        'attr' => [
                                           ['key' => 'maxlength', 'value' => '255']
                                        ]
                                    ],
                                ])
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-sm-12">
                                @include('forms/input-group-text',['placeholder'=>'Nhập link googleMapIframe...',
                                    'field'=>[
                                        'label'=>'Link Google_Map_Iframe', 'key'=>'link_map_iframe', 'class' => 'placement', 'name'=>'link_map_iframe', 'note' => '*', 'classNote' => 'text-danger',
                                        'attr' => [
                                           ['key' => 'maxlength', 'value' => '255'],
                                           ['key' => 'required', 'value' => 'required'],
                                        ]
                                    ],
                                ])
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="province_id">Tỉnh/ Thành phố</label>
                                    <select id="province_id" name="province_id"
                                            class="form-control{{ $errors->has('province_id') ? ' is-invalid' : '' }}"
                                            onchange="shop.admin.getDistrictsByProvinceId('stores')" >
                                        <option value="">-- Tỉnh/ Thành phố --</option>
                                        @foreach($provinces as $k => $v)
                                            <option value="{{ $v->id }}"
                                                    @if(old_blade('province_id') == $v->id) selected="selected" @endif>{{ $v->Name_VI }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="district_id">Quận/ Huyện</label>
                                    <select id="district_id" name="district_id"
                                            class="form-control{{ $errors->has('district_id') ? ' is-invalid' : '' }}">
                                        <option value="">-- Quận/ Huyện --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @include('forms/input-group-textarea',['placeholder'=>'Nội dung mô tả','field'=>['label'=>"Mô tả ngắn ",'key'=>'description', 'class'=>'seo', 'name'=>'description']])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                    <div class="form-group">
                                        <label >Danh sách ảnh</label>
                                        <div class="card-body" >
                                            <div class="card-box">
                                                <div class="row">
                                                    @include('BackEnd::pages.stores.include.gallery_store', [
                                                        'object_id' => old_blade('id')
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
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a href="#thong-tin-bo-sung" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            Xác định tọa độ trên bản đồ
                        </a>
                    </li>
                </ul>
                <div class="card-body">
                    <p>Ấn vào kính lúp nhập địa chỉ cần tìm và nhấn vào con thoi địa điểm để xác định vị trí *</p>
                    <div class="tab-content pt-0">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
            @if(!$preview)
                <div class="card">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="nav-item">
                            <a href="#thong-tin-bo-sung" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                Ảnh đại diện
                            </a>
                        </li>
                    </ul>
                    <div class="card-body">
                        <div class="tab-content pt-0">
                            <div class="tab-pane show active" id="thong-tin-bo-sung">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="image">Ảnh đại diện</label>
                                            <input type="file" class="dropify" data-default-file="{{ isset($obj) ? $obj->getImageUrl('original') : '' }}" name="image"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        @include('forms/input-group-radio-checked',[
                                            'type'=>'radio', 'field'=>[
                                                'label'=>'Trạng thái', 'name' => 'status',
                                                'obj' => [
                                                    ['id' => 'publish','class' => 'form-check-inline radio-success', 'key' => 'status', 'label' => 'Đăng ngay', 'value' => \App\Models\Stores::STATUS_ACTIVE],
                                                    ['id' => 'pending','class' => 'form-check-inline radio-warning', 'key' => 'status', 'label' => 'Chờ xét duyệt', 'value' => \App\Models\Stores::STATUS_INACTIVE],
                                                ]
                                            ],
                                            'data' => @$obj->status
                                        ])
                                    </div>
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
<!-- formEnds -->
</section>
<!-- // card-actions section end -->
@section('CSS_REGION')
   <style>
        #map {
        width: 100%;
        height: 300px;
        z-index:100;
        }
        #mapSearchContainer{
        position:fixed;
        top:20px;
        right: 40px;
        height:30px;
        width:180px;
        z-index:110;
        font-size:10pt;
        color:#5d5d5d;
        border:solid 1px #bbb;
        background-color:#f8f8f8;
        }
        .geocoder-control-expanded{
        width:400px !important
        }
   </style>
   {!! \Lib::addMedia('admin/libs/leaflet/leaflet.css') !!}
   {!! \Lib::addMedia('admin/libs/esri-leaflet-geocoder-0.0.1-beta.5/dist/esri-leaflet-geocoder.css') !!}
   {!! \Lib::addMedia('admin/libs/dropify/dropify.min.css') !!}
   {!! \Lib::addMedia('admin/js/library/uploadifive/uploadifive.css') !!}
   {!! \Lib::addMedia('admin/js/product_gallery/product_gallery.css') !!}
@stop
@push("JS_REGION")
    {!! \Lib::addMedia('admin/libs/leaflet/leaflet.js') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.js') !!}
    {!! \Lib::addMedia('admin/libs/esri-leaflet-0.0.1-beta.5/dist/esri-leaflet.js') !!}
    {!! \Lib::addMedia('admin/libs/esri-leaflet-geocoder-0.0.1-beta.5/dist/esri-leaflet-geocoder.js') !!}
    
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

                plugins: 'print preview importcss searchreplace autolink save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                mobile: {
                    plugins: 'print preview importcss searchreplace autolink save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons'
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
        
        $(document).ready(function () {
            let province_id = $('select[name="province_id"]').val();
            if (province_id !== '') {
                shop.admin.getDistrictsByProvinceId('stores', {{old_blade('district_id')}});
            }
            // Initialize the map and assign it to a variable for later use
            var map = L.map('map', {
                // Set latitude and longitude of the map center (required)
                center: [21.025109, 105.854706],
                // Set the initial zoom level, values 0-18, where 0 is most zoomed-out (required)
                zoom: 10
            });

            L.control.scale().addTo(map);

            // Create a Tile Layer and add it to the map
            //var tiles = new L.tileLayer('http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.png').addTo(map);
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var searchControl = new L.esri.Controls.Geosearch().addTo(map);

            var results = new L.LayerGroup().addTo(map);

            searchControl.on('results', function(data){
                results.clearLayers();
                for (var i = data.results.length - 1; i >= 0; i--) {
                results.addLayer(L.marker(data.results[i].latlng));
                }
            });

            setTimeout(function(){$('.pointer').fadeOut('slow');},3400);
            map.on('click', function(e) {
                alert("Đã chọn tọa độ đại lý mới");
                $('#obj-lat').val(e.latlng.lat);
                $('#obj-long').val(e.latlng.lng);
            });
        });

    </script>

@endpush