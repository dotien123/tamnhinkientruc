@extends('BackEnd::layouts.default')


@section('CONTENT_REGION')

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.'.$key) }}">Quản lý hoạt động chính</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Cập nhật bài viết</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12">
                    @include('BackEnd::pages.'.$key.'.include.input-form')
                </div>  <!-- end col -->

                <div class="col-lg-6">
                </div>

            </div>
        </div>
    </div>
@stop



@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/js/library/tag/jquery.tag-editor.css') !!}
    {!! \Lib::addMedia('admin/js/library/uploadifive/uploadifive.css') !!}
    {!! \Lib::addMedia('admin/libs/summernote/summernote-bs4.css') !!}
    {!! \Lib::addMedia('admin/libs/select2/select2.min.css') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.css') !!}
@stop

@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.js') !!}
    {!! \Lib::addMedia('admin/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') !!}
    {!! \Lib::addMedia('admin/libs/summernote/summernote-bs4.min.js') !!}
    {!! \Lib::addMedia('admin/libs/summernote/summernote-image-title.js') !!}
    <script>
        var news = {!! (old_blade('editMode')) ? json_encode($obj) : json_encode(['title' => (old('title')) ? old('title') : '', 'alias' =>(old('alias')) ? old('alias') : '']) !!};

    </script>
    {!! \Lib::addMedia('admin/js/library/slug.js') !!}
@endpush
