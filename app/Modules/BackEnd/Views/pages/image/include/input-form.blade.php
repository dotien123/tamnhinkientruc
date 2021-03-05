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
                        <div class="form-group mb-3">
                            <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" maxlength="250" autocomplete="off" id="placement" required name="title" value="{{ old('title', @$obj->title) }}" class="form-control" placeholder="e.g : Apple iMac">
                        </div>
                        <div class="form-group mb-3">
                            @include('forms/input-group-textarea',['placeholder'=>'Nhập nội dung mô tả ngắn hình ảnh','field'=>['label'=>"Nội dung mô tả",'key'=>'description', 'class'=>'seo', 'name'=>'description']])
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
                <input type="hidden" id="id_removeimage" value="{{ @$obj->id }}">
                <div class="card-content collapse show">
                    <div class="card-body">
                        <input type="file" data-img="{{ @$obj->image }}"  class="dropify" @if(@$obj['id']) data-default-file="{{ @$obj->getImageUrl('original', 'image', 'image') }}" @endif name="image"  />
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
            <!-- end col-->
            {{--<div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ảnh banner mobile</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <input type="file" class="dropify" @if(@$obj['id']) data-default-file="{{ @$obj->getImageUrl('original', 'mobile_image') }}" @endif name="mobile_image"  />
                    </div>
                </div>
            </div> <!-- end col-->--}}

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
    $(document).ready(function(){
        $('.dropify-clear').click(function(){
            var img = $('.dropify').attr('data-img');
            var id = $('#id_removeimage').val();
            shop.ajax_popup('image/removeimg', 'POST', {img:img, id:id}, function(img) {});
        });
    })
</script>

@endpush