<div class="table-responsive">
    <table class="table table-transparent" id="table-extended-chechbox">
        <thead>
        <tr>
            <th style="width: 20px;">
            </th>
            @foreach([
                "Họ và tên",
                "Số điện thoại",
                "Địa chỉ",
                "Ngày đăng ký",
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
            <th style="width: 20px;text-align: right">Cập nhật</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $k=>$value)
            <tr>
                <td >
                    <span >
                        {{str_pad($k+1, 2, '0', STR_PAD_LEFT)}}
                    </span>
                </td>
                <td style="width:130px">
                    {{ \StringLib::getStrVal(@$value['fullname'])}}
                </td>
                <td style="width:40px">
                    {{ $value->phone }}
                </td>
                <td style="width:220px">
                    {{$value->address}}
                </td>
                <td style="width:50px">
                    {{ \Lib::dateFormat($value->created, 'd/m/Y - H:i') }}
                </td>
                <td class="text-right">
                    <div class="dropdown" style="float: right">
                        <span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                        </span>
                        <div class="dropdown-menu dropdown-menu-right">
                            
                            @if(\Lib::can($permission, 'delete'))
                                <a title="Xóa bản ghi" href="{{ route('admin.'.$key.'.delete', $value->id) }}"
                                   class="dropdown-item xoa-ban-ghi"> <i class="menu-livicon mr-1" data-options="name: trash.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;" data-icon="trash"></i>Xóa</a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
