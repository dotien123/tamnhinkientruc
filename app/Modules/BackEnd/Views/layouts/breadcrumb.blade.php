@php($countBr = count($breadcrumb))
@if($countBr > 0 || !empty($extraCommand))
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h5 class="content-header-title float-left pr-1 mb-0">{{ ($countBr > 1) ? end($breadcrumb)['title'] : @$defBr['title'] }}</h5>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">
                                    <i class="bx bx-home-alt"></i></a>
                            </li>
                            @if($countBr > 1)
                                @foreach($breadcrumb as $item)
                                    @if($loop->last)
                                        <li class="breadcrumb-item active">{{ $item['title'] }}</li>
                                    @elseif(!$loop->first)
                                        <li class="breadcrumb-item">
                                            @if(!empty($item['link']))
                                                <a href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                                            @else
                                                {{ $item['title'] }}
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <li class="breadcrumb-item">{{ $defBr['title'] }}</li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif