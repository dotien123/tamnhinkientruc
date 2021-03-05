@extends('FrontEnd::layouts.home')
@section('metaTitle', 'danh mục tin tức - ô tô long biên')
@section('CONTENT_REGION')


@include('FrontEnd::layouts.banner_page')


<div class="breadcum__detail--product" style="margin: 30px 0;">
    <div class="container">
        <span style="text-transform: capitalize;"><a title="Trang chủ" href="{{ asset('/') }}">trang chủ </a>/
            <a title="Tin tức" href="{{ asset('/tin-tuc-m188') }}"> Tin tức </a>/ {!! $cate_search->title !!}
        </span>
    </div>
</div>

@include('FrontEnd::layouts.social')

<div class="empty-space" style="height: 25px;"></div>

<div class="container">
    <div class="row flex-lg-row-reverse">
        <div class="col-lg-9 col-12">
            <div class="blog--page">
                <div class="row">
                    <div class="col-12">
                        @if(!empty($data[0]))
                        <article class="big-post">
                            <div class="post-thumb">
                                <a href="{{ route('news.detail', ['alias' => @$data[0]->alias, 'id' => @$data[0]->id ]) }}">
                                    <img src="{{ \ImageURL::getImageUrl(@$data[0]->image, \App\Models\News::table_name, 'origin') }}"
                                        alt="{{ @$data[0]->title }}">
                                </a>
                            </div>
                            <div class="post-content">
                                <div class="post__posted-on">
                                    <p>{{ \Lib::dateFormat($data[0]->published) }}</p>
                                </div>
                                <div class="post__main-title">
                                    <a title="{{ @$data[0]->title }}" href="{{ route('news.detail', ['alias' => @$data[0]->alias, 'id' => @$data[0]->id ]) }}">
                                        <span>{{ $data[0]->title }}</span>
                                    </a>
                                </div>
                                <div class="post__main--description">
                                    {{ @$data[0]->description }}
                                </div>
                                <div class="post__btn--more">
                                    <a title="Xem thêm" class="single__text--hover" href="{{ route('news.detail', ['alias' => @$data[0]->alias, 'id' => @$data[0]->id ]) }}">Xem
                                        thêm</a>
                                </div>
                            </div>
                            
                        </article>
                        @endif
                    </div>
                    @if(isset($data))
                        @foreach (@$data as $k => $v)
                            @if ($k > 0)
                            <div class="col-lg-4 col-12 pr-0">
                                <article class="small-post">
                                    <div class="post-thumb">
                                        <a href="{{ route('news.detail', ['alias' => @$v->alias, 'id' => @$v->id ]) }}">
                                            <img src="{{ \ImageURL::getImageUrl(@$v->image, \App\Models\News::table_name, 'small') }}"
                                                alt="{{ @$data[1]->title }}">
                                        </a>
                                    </div>
                                    <div class="post-content">
                                        <div class="post__posted-on">
                                            <p>{{ \Lib::dateFormat(@$v->published) }}</p>
                                        </div>
                                        <div class="post__main-title">
                                            <a title={{ route('news.detail', ['alias' => @$v->alias, 'id' => @$v->id ]) }}">
                                                <span>{{ @$v->title }}</span>
                                            </a>
                                        </div>
                                        <div class="post__main--description">
                                            {{ App\Libs\Lib::str_limit(@$v->description, 120) }}
                                        </div>
                                        <div class="post__btn--more">
                                            <a title="Xem thêm" href="{{ route('news.detail', ['alias' => @$v->alias, 'id' => @$v->id ]) }}">Xem thêm</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            @include('FrontEnd::layouts.sidebar')
        </div>
    </div>
    <div class="pagi__right">
        <div class="box__images--pagination">
            <nav aria-label="...">
                <ul class="pagination">
                    @if(isset($data))
                    {{ @$data->links() }}
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
</div>
</div>
{{-- @include('FrontEnd::layouts.brand_icon')--}}
@stop

@push('JS_PLUGINS_REGION')
<script>
$(document).ready(function() {
    $('.danhmuc-toggle').removeClass('danhmuc-toggle-home');
    $('.danhmuc-dropdown').removeClass('danhmuc-dropdown-home');
})
</script>
@endpush