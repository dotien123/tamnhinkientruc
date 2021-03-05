@extends('FrontEnd::layouts.home')
@section('metaTitle', 'Tin tức - Tầm nhìn kiến trúc')
@section('CONTENT_REGION')

<div class="container">

    <div class="row">
       
        @if(!empty($data))
            @foreach($data as $k => $v)
                <div class="col-lg-12 col-12 news">
                    <div class="description_new row">
                        <div class="title_news col-12">
                            <p>{{ $v->title }}</p>
                        </div>
                        <div class="images_news col-12">
                            <img src="{{ \ImageURL::getImageUrl((@$v['image']), 'news', 'thumnail') }}" alt="">
                        </div>
                        <div class="content_news col-12">
                            <p>{{ $v->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

</div>

@endsection