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
                                <li class="breadcrumb-item"><a href="{{ route('admin.subscriber') }}">Danh sách liên hệ</a></li>
                                @if(old_blade('editMode'))
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Cập nhật danh sách</a></li>
                                @else
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Thêm bài danh sách</a></li>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-12">
                    @if( count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{!! $error !!}</div>
                            @endforeach
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success">
                            {!! session('status') !!}
                        </div>
                    @endif
                    @include('BackEnd::pages.subscriber.include.input-form')
                </div>  <!-- end col -->

                <div class="col-lg-6">
                </div>
            </div>
        </div>
    </div>
@stop