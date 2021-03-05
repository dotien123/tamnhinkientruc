@extends('FrontEnd::layouts.home')
@section('metaTitle', $obj->title)
@section('CONTENT_REGION')
@include('FrontEnd::layouts.banner_page')

<div class="breadcum__detail--product" style="margin: 30px 0;">
    <div class="container">
        <span style="text-transform: capitalize;"><a href="{{ asset('/') }}" title="Trang chủ">trang chủ </a>/ 
            <a href="{{ asset('/tin-tuc-m188') }}">Tin tức </a>
            @if(!empty($categories))/ <a href="{{ @$categories->safe_title }}-nw{{ @$categories->id }}" title="{{ @$categories->title }}">
                {{  @$categories->title }} </a> @endif/ {{ @$obj->title }} </span>
    </div>
</div>

{{-- <div class="empty-space" style="height: 55px;"></div> --}}

<div class="container">
    <div class="row flex-lg-row-reverse">
        <div class="col-lg-9 col-12">
            <div class="single__blog">
                <h1 class="single__main-title">
                    <span>{{ $obj->title }}</span>
                </h1>

                <div class="single__meta mb-3">
                    @if(isset($obj->created))
                    <div class="single__meta-item">
                        <img src="{{ asset('template/images/single-blog/watch.png')}}"> {{ \Lib::dateFormat($obj->created) }}
                    </div>
                    @endif

                    @if(isset($obj->views))
                    <div class="single__meta-item">
                        <img src="{{ asset('template/images/single-blog/eye.png')}}"> {{ $obj->views }}
                    </div>
                    @endif

                    <!-- bổ xung thêm số lượng bình luận -->
                    <!-- <div class="single__meta-item">
                        <img src="{{ asset('template/images/single-blog/chat.png')}}"> 12
                    </div> -->
                </div>

                @include('FrontEnd::layouts.components.sharing')
                <div class="single__content">
                    {!! $obj->description !!}
                </div>
                <div class="single__content">
                    {!! $obj->content !!}
                    <div class="single__author">
                        <span class="main">{{ $obj->source }}</span>
                        <span class="sub">{{ $obj->auths }}</span>
                    </div>
                </div>
            </div>
            <mycomment></mycomment>
            {{-- @include('FrontEnd::pages.news.include.comment') --}}

            @include('FrontEnd::layouts.comment')
            @include('FrontEnd::pages.news.include.relate')
        </div>
        <div class="col-lg-3 col-12">
            @include('FrontEnd::layouts.sidebar')
        </div>
    </div>
</div>
@stop
@section('CSS_REGION')

@endsection
@push('JS_PLUGINS_REGION')
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f56040c0213a1ad"></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
    src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v8.0&appId=215949582839597&autoLogAppEvents=1"
    nonce="4bugsUrp"></script>
@endpush