@extends('FrontEnd::layouts.home')
@section('metaTitle', 'Tin tức - Tầm nhìn kiến trúc')
@section('CONTENT_REGION')

<div class="container">

    <div class="row">
       
        @if(!empty($data))
            @foreach($data as $k => $v)
                <div class="col-lg-12 col-12 people">
                    <div class="description_people row">
                       
                        <div class="images_people  col-3">
                            <img src="{{ \ImageURL::getImageUrl((@$v['image']), 'icon', 'thumnail') }}" alt="">
                        </div>
                        
                        <div class="content_people  col-9">
                            <div class="title_people">
                                <p>{{ $v->title }}</p>
                            </div>
                            <p>{!! $v->description !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

</div>

@endsection