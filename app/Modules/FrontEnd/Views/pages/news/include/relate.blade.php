<div class="sp__detail--product">
    <div class="sp__divider"></div>
</div>
<div class="related__product">
    <span class="main__heading--title">Tin tức liên quan</span>
</div>
<div class="single__blog--related owl-theme owl-carousel">
@if(!empty($related))
    @foreach($related as $k => $v)

    <article class="small-post">
        <div class="post-thumb">
            <a href="{{ $v->alias }}-n-m-{{ $v->id }}" title="{{ $v->title }}">
                <img src="{{ \ImageURL::getImageUrl(($v->image), 'news', 'medium') }}" alt="{{ $v->title }}">
            </a>
        </div>
        <div class="post-content">
            <div class="post__posted-on">
                <p>{{ \Lib::dateFormat($v->published) }}</p>
            </div>
            <div class="post__main-title">
                <a href="{{ $v->alias }}-n-m{{ $v->id }}">
                    <span>{{$v->title}}</span>
                </a>
            </div>
        </div>
    </article>

    @endforeach
@endif
</div>