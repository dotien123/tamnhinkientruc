<div class="table-responsive">
    <div class="d-none" id="popup-action">
        <div class="show">
            <a href="javascript:void(0)" class="btn btn-danger mb-3 text-light mt-2 ml-2" onclick="shop.admin.checkAllAction('purchase', 'status', -1)" title="Xóa tất cả bản ghi đã chọn">Xóa</a>
        </div>
    </div>
    <table class="table table-transparent" id="table-extended-chechbox">
        <thead>
        <tr>
            <th width="20" class="text-center">
                <label><input type="checkbox"  class="checkbox-all-item-input custome-checkbox"><span></span></label>
            </th>
            </th>
            @foreach([
                "Họ và tên",
                "Email",
                "Số điện thoại",
                "Tiêu đề sản phẩm",
                "Giá sản phẩm",
                "Số tiền đã trả",
                "Số tiền trả hàng tháng",
                "Thời hạn trả (tháng)",
                "Lãi suất (%)",
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
            <th style="width: 20px;text-align: right">Xóa</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $k=>$value)
            <tr>
                <td align="center">
                    <label><input type="checkbox" name="checkbox-item-input[]"  class="checkbox-item-input custome-checkbox check-item" value="{{$value->id}}"><span></span></label>
                </td>
               
                <td style="width:100px">
                    {{ \StringLib::getStrVal(@$value['fullname'])}}
                </td>
                
                <td style="width:100px">
                    @if($value->customer_id > 0)
                        <a class="text-primary" href="{{route('admin.customer.edit', $value->customer_id)}}" target="_blank">{{ @$value->email }}</a>
                    @else
                        <a class="text-dark">{{ $value->email }}</a>
                    @endif
                </td>
                <td style="width:40px">
                    {{ $value->phone }}
                </td>
                <td style="width:130px">
                    {{ $value->title }}
                </td>
                <td style="width:40px">
                    {{ numberFormat($value->giaxe) }} VNĐ
                </td>

                <td style="width:40px">
                    {{ numberFormat($value->tratruoc) }} VNĐ
                </td>
                <td style="width:40px">
                    {{ numberFormat($value->price_purchase) }} VNĐ
                </td>
                <td style="width:40px">
                    {{ $value->thoihanvay }}
                </td>
                <td style="width:40px">
                    {{ $value->laisuat }}
                </td>

                
                <td style="width:50px">
                    {{ \Lib::dateFormat($value->created, 'd/m/Y - H:i') }}
                </td>
                <td>
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
