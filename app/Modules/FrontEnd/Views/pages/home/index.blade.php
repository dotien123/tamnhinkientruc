@extends('FrontEnd::layouts.home')
@section('metaTitle', 'Trang chủ - Tầm nhìn kiến trúc')
@section('CONTENT_REGION')
{{-- <div class="content">

    <div class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($banner as $k =>  $value)
                    <li class="splide__slide">
                        <a href="{{ $value['link'] ?? 'javacript:void(0)'  }}" target="_blank"><img src="{{ \ImageURL::getImageUrl(($value['image']), 'feature', 'original') }}" alt=""></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    

</div> --}}


<div class="content">
    <main style="margin-bottom: 30px">
        <div class="container">
            <div class="carousel slide" id="main-carousel" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($banner as $k =>  $value)
                        <li data-target="#main-carousel" data-slide-to="{{ $k }}" @if($k == 0) class="active" @endif></li>
                    @endforeach
                </ol>
                <!-- /.carousel-indicators -->

                <div class="carousel-inner">
                    @foreach ($banner as $k =>  $value)
                        <div class="carousel-item @if($k == 0) active @endif">
                            <a class="d-block img-fluid" href="{{ @$value->link ?? 'javacript:void(0)'  }}" target="_blank">
                                <img src="{{ \ImageURL::getImageUrl((@$value->image), 'feature', 'original') }}" style="width:100%" alt="">
                            </a>
                            <div class="carousel-caption d-none d-md-block">
                                <h1>{{ @$v->title }}</h1>
                            </div>
                        </div>
                    @endforeach

                </div><!-- /.carousel-inner -->

                <a href="#main-carousel" class="carousel-control-prev" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="sr-only" aria-hidden="true">Prev</span>
                </a>
                <a href="#main-carousel" class="carousel-control-next" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="sr-only" aria-hidden="true">Next</span>
                </a>
            </div><!-- /.carousel -->
        </div><!-- /.container -->
    </main>
</div>
@endsection
