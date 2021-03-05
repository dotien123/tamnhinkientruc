<section id="card-actions">
    @if(old_blade('editMode'))
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')), 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'files' => true]) !!}
    @endif
    <div class="row">
        <div class="col-lg-8 col-12">
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
                                'label'=>'Tiêu đề bài viết', 'key'=>'title', 'note' => '*', 'class' => 'placement', 'classNote' => 'text-danger','name'=>'title',
                                'attr' => [
                                ['key' => 'maxlength', 'value' => '255'],
                                ['key' => 'v-model', 'value' => 'input'],
                                ['key' => 'required', 'value' => 'required'],
                                ]
                                ],
                                ])
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <strong>Liên kết tĩnh &nbsp;</strong> 
                                        @if(old_blade('editMode'))
                                        <span id="sample-permalink" class="fs-13">
                                            <a href="{{ route('introduce.detail',['alias' => @$obj->alias, 'id' => @$obj->id]) }}" target="_blank"> {{ route('introduce.detail',['alias' => @$obj->alias, 'id' => @$obj->id]) }}</a>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="input-group">
                                        <input value="{{ @$obj->alias }}" type="text" name="alias" class="form-control th-service text-blue" id="basic-url" aria-describedby="basic-addon3" placeholder="Liên kết tĩnh">
                                    </div>
                                </div>
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
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="type">Loại giới thiệu</label>
                                    <select id="type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                                        @foreach($type as $k => $v)
                                            <option value="{{ $k }}"  @if(!empty($obj)) @if(old('type',$obj->type) == $k) selected="selected" @endif @endif>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                @include('forms/input-group-textarea',['field'=>['label'=>"Mô tả ",'key'=>'des_content', 'id' => 'des_content', 'name'=>'des_content',]])
                            </div><!-- end col -->
                        </div>
                        <div class="row">
                            <div class="col-12">
                                @include('forms/input-group-textarea',['field'=>['label'=>"Nội dung chính ",'key'=>'content', 'id' => 'content', 'name'=>'content',]])
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            @if(!$preview)
                <div class="card">
                    <ul class="nav nav-tabs nav-bordered nav-justified">
                        <li class="nav-item">
                            <a href="#thong-tin-bo-sung" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                Thông tin khác
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#seo" data-toggle="tab" aria-expanded="true" class="nav-link">
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
                                        <label for="obj-title">Ảnh đại diện</label>
                                        <input type="file" data-img="{{ @$obj->image }}" class="dropify" data-default-file="{{ isset($obj) ? $obj->getImageUrl('image', 'page_intro', 'original') : '' }}" name="image"  />
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        @include('forms/input-group-text',['placeholder'=>'Link tìm hiểu thêm nếu có...',
                                        'field'=>[
                                        'label'=>'Link tìm hiểu thêm','name'=>'link', 'key'=>'link',  'classNote' => 'text-warning d-block',
                                        ],
                                        ])
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        @include('forms/input-group-radio-checked',[
                                        'type'=>'radio', 'field'=>[
                                        'label'=>'Trạng thái', 'name' => 'status',
                                        'obj' => [
                                        ['id' => 'publish','class' => 'form-check-inline radio-success', 'key' => 'status', 'label' => 'Đăng ngay', 'value' => \App\Models\PageIntro::STATUS_ACTIVE],
                                        ['id' => 'pending','class' => 'form-check-inline radio-warning', 'key' => 'status', 'label' => 'Chờ xét duyệt', 'value' => \App\Models\PageIntro::STATUS_INACTIVE],
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
                            <div class="tab-pane" id="seo">
                                @include('forms/seo-group')
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
                <a href="{{ route('admin.'.$key) }}" class="btn btn-light  btn-xs mr-3">Bỏ qua</a>
            @endif

          

            @if($preview && @$obj['id'])
                <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id')) }}"
                   class="btn btn-warning waves-effect mr-3"><i class="fe-edit"></i> Sửa thông tin</a>
            @else

                <button type="submit"
                        class="btn btn-teal-800 waves-effect waves-light mr-3"><i class="fe-save"></i> Cập nhật</button>
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
            shop.ajax_popup('page_intro/ajaxItemImgDel', 'POST', {img:img, id:id}, function(img) {});
        });
    })
</script>
@endpush
