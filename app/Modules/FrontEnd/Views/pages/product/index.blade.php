@extends('FrontEnd::layouts.home')
@section('metaTitle', 'danh sách sản phẩm - ô tô long biên')
@section('CONTENT_REGION')
<script src="https://code.jquery.com/jquery-3.5.1.js" ></script>

<div class="tbl-tab">
    <ul>
        <li><a href="javascript:void(0)" class="nav active" data-type='grid'>word timeline grid</a></li>
        <li><a href="javascript:void(0)" class="nav" data-type='images'>word timeline images </a></li>
        <li><a href="javascript:void(0)" class="nav" data-type='lists'>word timeline lists</a></li>
    </ul>
</div>

<div class="container">

    <div class="row gird">
        @if(!empty($project))
            @foreach ($project as $k => $v)
                <div class="col-sm-4 project1">
                    <a href="{{ route('project.detail', ['alias' => $v->alias, 'id' => $v->id]  ) }}">
                        <img src="{{ \ImageURL::getImageUrl((@$v['image']), 'product', 'original') }}" alt="">
                    </a>
                    <div class="text">
                        <span style="font-weight: bold;"><a href="{{ route('project.detail', ['alias' => $v->alias, 'id' => $v->id]  ) }}">{{ @$v->title }}</a></span>
                        </br>
                        <span style="font-size: medium;font-weight: 300;">{{ @$v->location?? 'original' }}</span>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="row images_timeline">
        <div class="col-lg-4 col-12">
            @if(!empty($cate))
                @foreach($cate as $k => $v)
                    <div class="sider_bar">
                        <div class="combo" data-id="{{ $v->id }}" onclick="getdataCategories({{ $v->id }})">
                            <div class="year">{{ $v->content }}</div>
                            <div class="title">{{ $v->title }}</div>
                            <div class="read">{{ $v->description ??  'original'}}</div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="col-lg-8 col-12">
            <div class="row" id="data_cate">
                @if(!empty($project))
                    @foreach ($project as $k => $v)
                        <div class="col-4 project2">
                            <a href="{{ route('project.detail', ['alias' => $v->alias, 'id' => $v->id]  ) }}">
                                <img src="{{ \ImageURL::getImageUrl((@$v['image']), 'product', 'original') }}" alt="">
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="row lists_timeline">
        <div class="menu_title">
            <div>
                <p>year</p>
            </div>
            <div>
                <p>Title</p>
            </div>
            <div>
                <p>Location</p>
            </div>
            <div>
                <p>Category</p>
            </div>
        </div>

        <div class="content type" id="load_data">
            @if (isset($project_cate) && !empty($project_cate))
                @foreach ($project_cate as $key => $item)
                    <div class="description">
                        <div class="year">{{ $item->year ? $item->year :  \Carbon\Carbon::now()->format('Y') }}</div>
                        <div class="title"><a href="{{ route('project.detail', ['alias' => $v->alias, 'id' => $v->id]  ) }}">{{ $item->title }}</a></div>
                        <div class="location">{{ $item->location }}</div>
                        <div class="category">{{ $item->category->title ?? 'Đang cập nhật' }}</div>
                    </div>
                @endforeach
            @endif
            
        </div>
        @if(count($project_cate) > 10)
            <div class="laod_more" data-type="1">
                <div class="title">
                    <span>Load More</span>
                </div>
            </div>
        @endif




    </div>

</div>

<script>
    $(document).ready(function(){
        $('.nav').click(function () { 
            $('.nav').removeClass('active');
            $(this).addClass('active');
            var type = $(this).attr('data-type');

            if(type === 'images')
            {
                $('.images_timeline').css("display","flex");
                $('.gird').css("display","none");
                $('.lists_timeline').css("display","none");
            }

            if(type === 'grid'){
                $('.gird').css("display","flex");
                $('.images_timeline').css("display","none");
                $('.lists_timeline').css("display","none");
            }

            if(type === 'lists'){
                $('.lists_timeline').css("display","flex");
                $('.gird').css("display","none");
                $('.images_timeline').css("display","none");
            }

        });

        $('.laod_more').click(function () { 
            let $val = $(this).attr('data-type');
            let $type = parseInt($val) + parseInt(1);
            $(this).attr('data-type', $type);
            $.ajax({
                type:'POST',
                url:"{{ route('project.loadmore') }}",
                data: {type: $type, _token: '{{ csrf_token() }}'},
                success:function(data) {
                    $("#load_data").html(data.result);
                }
            });
        });


    });

    function getdataCategories($id) {
        $.ajax({
            type:'POST',
            url:"{{ route('project.calldatacate') }}",
            data: {id: $id,_token: '{{ csrf_token() }}'},
            success:function(data) {
                $("#data_cate").html(data.result);
            }
        });
    }

</script>

@stop