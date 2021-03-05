@extends('FrontEnd::layouts.home')
@section('metaTitle', 'Trang chủ - Tầm nhìn kiến trúc')
@section('CONTENT_REGION')

<div class="content">

    <div class="row">
        <div class="col-12 about">
            {!! $page->body !!}
        </div>
    </div>
</div>

@endsection