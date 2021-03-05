@extends('FrontEnd::layouts.home')
@section('metaTitle', 'Tầm nhìn kiến trúc')
@section('CONTENT_REGION')

<div class="container">

    <div class="row">
        
        <div class="col-lg-8 detail-image">
            <img src="{{ \ImageURL::getImageUrl((@$obj['image']), 'product', 'original') }}" alt="">
        </div>
        <div class="col-lg-4 col-12">
            <h1>{{ @$obj->title }}</h1>
            <div class="code">
                <p>Date: {{ @$obj->date ?? '' }}</p>
                <p>Client: {{ @$obj->client ?? '' }}</p>
                <p>Location: {{ @$obj->location ?? '' }}</p>
                <p>Category project: {{ @$obj->category->title ?? ''}}</p>
                <p>Year project: {{ @$obj->year ?? ''}}</p>
            </div>
            <div class="cont">
                <p>{{ @$obj->description ?? '' }}</p>
            </div>
        </div>

    </div>

</div>

@endsection