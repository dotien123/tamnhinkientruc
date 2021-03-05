<div class="col-lg-6">
    <h2 class="main-title main-title-line">TIN TỨC SỰ KIỆN</h2>
    <div class="news">
        <div class="row">
            @if(!empty($new))
            <div class="col-md-8 mb-4 mb-lg-0">
                @if (!empty(@$new[0]))
                <div class="news-big">
                    <a title="{{ @$new[0]->title }}" href="{{ @$new[0]->alias }}-n-m{{ @$new[0]->id }}" class="image"><img
                            src="{{ \ImageURL::getImageUrl(@$new[0]->image, 'news', 'medium') }}"
                            alt="{{ @$new[0]->title }}"></a>
                    <div class="desc">
                        <a title="{{ @$new[0]->title }}" href="{{ @$new[0]->alias }}-n-m{{ @$new[0]->id }}" class="title">{{ @$new[0]->title }}</a>
                        <div class="date">{{ \Lib::dateFormat(@$new[0]->published) }}</div>
                        <p>{{ @$new[0]->description }}</p>
                        <a  title="{{ @$new[0]->title }}" href="{{ @$new[0]->alias }}-n-m{{ @$new[0]->id }}" class="link single__text--hover">Xem
                            thêm</a>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-md-4">
                @foreach ($new as $k => $v)
                @if ($k > 0)
                <div class="news-thumb">
                    <a title="{{ $v->title }}" href="{{ $v->alias }}-n-m{{ $v->id }}" class="image"><img
                            src="{{ \ImageURL::getImageUrl($v->image, 'news', 'medium') }}"
                            alt="{{ @$v->title ?? 'tin tức' }}"></a>
                    <a title="{{ $v->title }}"  href="{{ $v->alias }}-n-m{{ $v->id }}" class="title">{{ $v->title }}</a>
                </div>
                @endif
                @endforeach
            </div>
            @endif

        </div>
        <div class="text-right">
            <a href="{{ asset('/tin-tuc-m188') }}" class="link-all single__text--hover">Xem tất cả >></a>
        </div>
    </div>
</div>