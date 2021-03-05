<div class="table-full">
    <table class="table table-centered table-hover" id="products-datatable">
        <thead>
        <tr>
            <th style="width: 20px;">
            </th>
            @foreach([
                "Thời gian",
                "Hành động",
                "Link liên kết",
                "Thiết bị",
                "IP",
                "Ghi chú"
            ] as $k=> $label)
                <th title="{{$label}}">
                    <div class="sp-line-1">
                        {{$label}}
                    </div>
                    @if($k==0)
                        <div><span class="text-danger">({{@$data->total()}}) bản ghi</span></div>
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($data as $k=>$value)
            <tr>
                <td class="td-number ribbon-box">
                    <span class="td-number-value ribbon ribbon-teal-800 float-left">
                        {{str_pad($k+1, 2, '0', STR_PAD_LEFT)}}
                    </span>
                </td>
                <td>
                    {{ \Lib::dateFormat($value->created, 'd/m/Y - H:i:s') }}
                </td>
                <td style="width:500px" class="text-capitalize">
                    <span class="text-success">{{ \StringLib::getStrVal(@$value->getAction()) }}</span>
                </td>
                <td>
                    @if(!empty($value->url))
                        <a href="{{ $value->url }}" title="{{ $value->url }}" target="_blank">{{ App\Libs\Lib::str_limit($value->url, 40) }}</a>
                    @endif
                </td>
                <td>
                    {{ $value->getDevice() }}
                </td>
                <td class="text-capitalize">
                    {{ \StringLib::getStrVal(@$value->ip) }}
                </td>
                <td>
                    {{ \StringLib::getStrVal(@$value->note) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
