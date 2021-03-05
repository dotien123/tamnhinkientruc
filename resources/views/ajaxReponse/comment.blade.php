@if(!empty($data))
    @foreach (@$data as $k => $v)
        @if($k > 2)
            <div class="single__comment--list comment__reply--after" style="z-index: unset;">
                <div class="single__comment--people">
                    @if(!empty(@$v->uid) > 0)
                        <img src="{{ @$config['favicon_images']?:public_link('favicon.ico') }}">
                    @else
                        <img src="{{ asset('template/images/user_img.png') }}">
                    @endif
                    <span class="name">{!! $v->uid > 0 ? @$v->getUername($v->uid) : $v->customer_name !!} </span>
                </div>
                <div class="single__comment--reply">
                    <p class="comment_content">{!! $v->v > 0 ? @$v->comment : $v->comment !!}</p>
                </div>

                <div class="single__comment--meta">
                    <a data-id="{{ $v->id }}" href="javascript:void(0)" class="rep"><img
                            src="{{ asset('template/images/single-blog/reload.png') }}" alt="icon web">Trả
                        lời</a>
                    <span>{{ \Lib::dateFormat($v->created) }}</span>
                    <span>{{ \Lib::dateFormat1($v->created) }}</span>
                </div>
            </div>
        @endif
    @endforeach
@endif

