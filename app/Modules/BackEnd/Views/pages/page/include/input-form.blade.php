<section id="card-actions">
    @if(old_blade('editMode'))
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')) , 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post') , 'files' => true]) !!}
    @endif
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin chi tiết </h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row" id="slug-alias">
                                
                                {{-- <div class="col-sm-12">
                                    @include('forms/input-group-radio-checked',[
                                        'type'=>'radio', 'field'=>[
                                            'label'=>'Loại đăng', 'name' => 'type',
                                            'obj' => [
                                                ['id' => 'type1','class' => 'form-check-inline radio-success', 'key' => 'type', 'label' => 'Mua trả góp', 'value' => 0],
                                                ['id' => 'type2','class' => 'form-check-inline radio-warning', 'key' => 'type', 'label' => 'Về chúng tôi', 'value' => 1],
                                                // ['id' => 'type3','class' => 'form-check-inline radio-success', 'key' => 'type', 'label' => 'Bảng giá', 'value' => 2],
                                                ['id' => 'type4','class' => 'form-check-inline radio-success', 'key' => 'type', 'label' => 'Vì sao nên chọn chúng tôi', 'value' => 3],
                                            ]
                                        ],
                                        'data' => @$obj->type
                                    ])
                                </div> --}}

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
                                        <label for="type">Chọn tình trạng xe</label>
                                        <select id="tt" name="tt_id" class="form-control">
                                            <option value="">-- Chọn tình trạng xe -- </option>
                                        </select>
                                    </div>
                                </div> --}}
{{--                                <div class="col-sm-12">--}}
{{--                                    <div class="form-group">--}}
{{--                                            <label for="alias">Liên kết tĩnh</label>--}}
{{--                                            <div class="input-group">--}}
{{--                                                <div class="input-group-prepend">--}}
{{--                                                    <span class="input-group-text">{{ public_link() }}/page/</span>--}}
{{--                                                </div>--}}
{{--                                                <input :value="slug" required type="text" name="alias" class="form-control th-service text-blue" id="basic-url" aria-describedby="basic-addon3">--}}
{{--                                            </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                            {{-- <div class="row">
                                <div class="col-sm-12">
                                    @include('forms/input-group-textarea',['placeholder'=>'Nội dung mô tả','field'=>['label'=>"Mô tả ngắn ",'key'=>'sort_body', 'class'=>'seo', 'name'=>'sort_body']])
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-12">
                                    @include('forms/input-group-textarea',['placeholder'=>'', 'field'=>['label'=>"Nội dung chính",'key'=>'body', 'id' => 'content', 'name'=>'body',]])
                                </div>
                            </div>
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
                            <li class="nav-item">
                                <a href="#seo" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                    SEO
                                </a>
                            </li>
                        </ul>
                        <div class="card-body">
                            <div class="tab-content pt-0">
                                <div class="tab-pane show active" id="thong-tin-bo-sung">
                                <input type="hidden" id="id_removeimage" value="{{ @$obj->id }}">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="image">Ảnh đại diện</label>
                                                <input type="file" data-img="{{ @$obj->image }}"  class="dropify" data-default-file="{{ \ImageURL::getImageUrl(@$obj->image, 'page', 'original') }}" name="image"  />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            @include('forms/input-group-radio-checked',[
                                                'type'=>'radio', 'field'=>[
                                                    'label'=>'Trạng thái', 'name' => 'status',
                                                    'obj' => [
                                                        ['id' => 'publish','class' => 'form-check-inline radio-success', 'key' => 'status', 'label' => 'Đăng ngay', 'value' => \App\Models\Page::STATUS_ACTIVE],
                                                        ['id' => 'pending','class' => 'form-check-inline radio-warning', 'key' => 'status', 'label' => 'Chờ xét duyệt', 'value' => \App\Models\Page::STATUS_INACTIVE],
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
                                <div class="tab-pane show " id="seo">
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
    $(document).ready(function(){
        $('.dropify-clear').click(function(){
            var img = $('.dropify').attr('data-img');
            var id = $('#id_removeimage').val();
            shop.ajax_popup('page/ajaxItemImgDel', 'POST', {img:img, id:id}, function(img) {});
        });
    })
</script>
@endpush
@push("JS_REGION")
    <script>
        var news = {!! '{title: "'.old_blade('title').'", alias: "'.old_blade('title').'"}' !!};
    </script>
    {!! \Lib::addMedia('admin/js/library/slug-news.js') !!}
@endpush




