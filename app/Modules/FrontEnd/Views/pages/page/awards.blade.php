@extends('FrontEnd::layouts.home')
@section('metaTitle', 'Trang chủ - Tầm nhìn kiến trúc')
@section('CONTENT_REGION')

<div class="content">

    @if ($award)
        @foreach ($award as $k => $item)
            <div class="row data">
                <div class="col-lg-4 col-12 awards">
                    <img src="{{ \ImageURL::getImageUrl((@$item['image']), 'image', 'thumnail') }}" alt="">
                </div>
                <div class="col-lg-8 col-12 content_des">
                    <span>{{ $item->title }}</span>
                    <p>{{ $item->description }}</p>
                </div>
            </div>
        @endforeach
    @endif
    
</div>

@endsection