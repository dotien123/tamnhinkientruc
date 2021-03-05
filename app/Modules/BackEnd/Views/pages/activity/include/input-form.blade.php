@if(old_blade('editMode'))
    {!! Form::open(['url' => route('admin.'.$key.'.edit.post', old_blade('id')), 'class' => 'row', 'files' => true]) !!}
@else
    {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'class' => 'row', 'files' => true]) !!}
@endif
<div class="col-lg-8 col-12">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <ul class="nav nav-tabs nav-bordered nav-justified">
            <li class="nav-item">
                <a href="#thong-tin-chi-tiet" data-toggle="tab" aria-expanded="false" class="nav-link text-left active">
                    Thông tin chi tiết
                </a>
            </li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    @include('forms/input-group-text',['placeholder'=>'Nhập tiêu đề hoạt động...',
                        'field'=>[
                            'label'=>'Tiêu đề hoạt động', 'key'=>'title', 'class' => 'placement', 'name'=>'title', 'note' => '*', 'classNote' => 'text-danger',
                            'attr' => [
                               ['key' => 'maxlength', 'value' => '255'],
                               ['key' => 'required', 'value' => 'required'],
                            ]
                        ],
                    ])

                    @include('forms/input-group-text',['placeholder'=>'Nhập liên kết tĩnh...',
                        'field'=>[
                            'label'=>'Liên kết tĩnh', 'key'=>'link', 'class' => 'placement', 'name'=>'link', 'note' => '*', 'classNote' => 'text-danger',
                            'attr' => [
                               ['key' => 'maxlength', 'value' => '255'],
                               ['key' => 'required', 'value' => 'required'],
                            ]
                        ],
                    ])
                    @include('forms/input-group-text',['placeholder'=>'Nhập số thứ tự mà bạn muốn',
                        'field'=>[
                            'type' => 'number',
                            'label'=>'Sắp xếp', 'key'=>'sort', 'name'=>'sort',
                            'attr' => [
                               ['key' => 'min', 'value' => '1'],
                            ]
                        ],
                    ])
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="image">Ảnh đại diện</label>
                        <input type="file" class="dropify" data-default-file="{{ isset($obj) ? $obj->getImageUrl() : '' }}" name="image"  />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    @include('forms/input-group-textarea',['placeholder'=>'Nội dung mô tả','field'=>['label'=>"Mô tả ngắn ",'key'=>'description', 'class' => 'seo', 'name'=>'description']])
                </div>
            </div>
            {{-- <div class="">
                <div class="col">
                    <label class="checkbox-inline" for="newtab">
                        <input type="checkbox" id="newtab" name="newtab" value="1" @if(old('newtab', @$data->newtab) == 1) checked @endif>  Bật Tab mới
                    </label>
                </div>
            </div> --}}
        </div>
    </div>

</div>
{{--<div class="col-lg-4">
    @if(!$preview)
        <div class="card">
            <ul class="nav nav-tabs nav-bordered nav-justified">
                <li class="nav-item">
                    <a href="#seo" data-toggle="tab" aria-expanded="true" class="nav-link active text-left">
                        Thông tin SEO
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
</div>--}}


<div class="bottom-control">
    <div class="container-fluid control-item">
        @if(@$obj['id'] && \Lib::can($permission, 'delete'))
            @if($obj['removed'] == 1)
                <a href="javascript:void(0)"
                   onclick="shop.admin.revertItem({{ $obj['id'] }}, true, 'activity')"
                   class="btn btn-warning waves-effect btn-xs mr-3"><i class="fe-refresh-cw"></i> Khôi phục</a>
            @else
                <a href="javascript:void(0)"
                   onclick="shop.admin.revertItem({{ $obj['id'] }}, false, 'activity')"
                   class="btn btn-danger waves-effect btn-xs mr-3"><i class="fe-delete"></i> Xóa</a>
            @endif
        @endif

        @if($view=='popup')
            <a onclick="_CLOSE_MODAL()" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>

            @if( @$obj['id'])
                <a href="{!! admin_link('/spk-notification/input?id='.$obj['_id'].'&preview=1') !!}"
                   class="btn btn-light waves-effect mr-3 btn-xs"><i class="fe-eye"></i> Xem chi tiết </a>
            @endif

        @else
            <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>
        @endif
        @if(\Lib::can($permission, 'edit'))
            @if($preview && @$obj['id'])
                <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id')) }}"
                   class="btn btn-warning waves-effect mr-3"><i class="fe-edit"></i> Sửa thông tin</a>
            @else
                @if( @$obj['id'])
                    <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id').'?preview=1') }}"
                       class="btn btn-light waves-effect mr-3 btn-xs"><i class="fe-eye"></i> Xem chi tiết </a>
                @endif

                <button type="submit"
                        class="btn btn-teal-800 waves-effect waves-light mr-3"><i class="fe-save"></i> Cập nhật</button>
            @endif
        @endif


    </div>
</div>
{!! Form::close() !!}

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
        });

    </script>
@endpush