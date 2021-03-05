<section id="card-actions">
    @if(old_blade('editMode'))
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')), 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'files' => true]) !!}
    @endif
    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="card" id="slug-alias">
                <div class="card-header">
                    <h4 class="card-title">Thông tin chi tiết </h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="title">Tên video <span class="text-danger">*</span></label>
                            <input type="text" maxlength="250" autocomplete="off" id="placement" required name="title" value="{{ old('title', @$obj->title) }}" class="form-control" placeholder="Tiêu đề video">
                        </div>
                        <div class="form-group mb-3">
                           
                            @include('forms/input-group-text',['placeholder'=>'Nhập Link video...',
                                'field'=>[
                                    'label'=>'Link video', 'key'=>'link_origin', 'class' => 'placement', 'name'=>'link_origin', 'note' => '*', 'classNote' => 'text-danger',
                                    'attr' => [
                                        ['key' => 'maxlength', 'value' => '255'],
                                        ['key' => 'required', 'value' => 'required'],
                                        ['key' => 'data-validation-required-message', 'value' => 'Link video không được để trống.'],
                                    ]
                                ],
                            ])

                        </div>
                        {{-- <div class="form-group mb-3">
                            @include('forms/input-group-textarea',['placeholder'=>'Nhập nội dung mô tả video','field'=>['label'=>" ",'key'=>'description', 'class'=>'seo', 'name'=>'description']])
                        </div> --}}
                        
                    </div>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
        <div class="col-lg-4 col-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ảnh</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        @if(substr_count(@$obj->image, 'http://i3.ytimg.com/vi/') == 0 && @$obj->image != '')
                            <input type="file" id="img_video" class="dropify" @if(@$obj['id']) data-default-file="{{ @$obj->getImageUrl('image', 'video', 'original') }}" @endif name="image"  />
                        @else
                            <input type="file" id="img_video" class="dropify" @if(@$obj['id']) data-default-file="{{ @$obj->thumbnail }}" @endif name="image"  />
                        @endif
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
                        <input type="hidden" id="fucking_video_id" name="fucking_video_id" value="{{@$obj['video_id']}}">
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
</section>
@push("JS_REGION")
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
    <script>
        
        $(document).ready(function () {
            $("#obj-link_origin").keyup(function(){
                let link = $(this).val();
                let id   = shop.admin.youtube_video_id(link);
                let url  = 'http://i3.ytimg.com/vi/'+ id +'/hqdefault.jpg';
                let image = '<img src="http://i3.ytimg.com/vi/'+id+'/hqdefault.jpg">';

                $('.dropify-preview').css("display","block");
                $(".dropify-render").html(image);
                $("#img_video").attr('data-default-file', url);
                $('#fucking_video_id').val(id);
            });

            // function getBase64Image(img) {
            //     var canvas = document.createElement("canvas");
            //     canvas.width = img.width;
            //     canvas.height = img.height;
            //     var ctx = canvas.getContext("2d");
            //     var dataURL = canvas.toDataURL("image/png");
            //     return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
            // }


            


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

@endpush