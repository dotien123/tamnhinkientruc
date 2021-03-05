<div class="table-full">
    <div class="d-none" id="popup-action">
        <div class="show">
            <a href="javascript:void(0)" class="btn btn-danger mb-3 text-light mt-2 ml-2" onclick="shop.admin.checkAllAction('activity', 'status', -1)" title="Xóa tất cả bản ghi đã chọn">Xóa</a>
        </div>
    </div>
    <table class="table table-centered table-striped" id="products-datatable">
        <thead>
        <tr>
            <th width="20" class="text-center">
                <label><input type="checkbox"  class="checkbox-all-item-input custome-checkbox"><span></span></label>
            </th>
            </th>
            @foreach([
                "Tên",
                "Liên kết tĩnh",
                "Ảnh đại diện",
                "Trạng thái",
                "Ngày tạo"
            ] as $k=> $label)
                <th title="{{$label}}">
                    <div class="sp-line-1">
                        {{$label}}
                    </div>
                    @if($k==0)
                        <div><span class="text-danger">({{@$lsObj->total()}}) bản ghi</span></div>
                    @endif
                </th>
            @endforeach

            <th style="width: 20px;text-align: right"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($lsObj as $k=>$value)
            <tr>
                <td align="center">
                    <label><input type="checkbox" name="checkbox-item-input[]"  class="checkbox-item-input custome-checkbox check-item" value="{{$item->id}}"><span></span></label>
                </td>
                <td class="td-number ribbon-box">
                    <span class="td-number-value ribbon ribbon-teal-800 float-left">
                        {{str_pad($k+1, 2, '0', STR_PAD_LEFT)}}
                    </span>
                </td>
                <td style="width:350px">
                    {{ \StringLib::getStrVal(@$value['title'])}}
                </td>
                <td>
                    <a target="_blank" href="{{ \StringLib::getStrVal(@$value['link'])}}">{{ \StringLib::getStrVal(@$value['link'])}}</a>
                </td>
                <td>
                    <img height="100px" src="{{ $value->getImageUrl() }}" alt="{{ \StringLib::getStrVal(@$value['title'])}}">
                </td>
                <td style="width:110px">
                    @if($value->status != -1)
                    <div class="switchery-demo">
                        <input type="checkbox" class="switchery" data-plugin="switchery" data-id="{{ @$value->id }}" data-color="#00695c" @if($value->status) checked @endif data-size="small"/>
                    </div>
                    @else 
                        <span class="badge badge-danger badge-pill">
                            Đã xóa
                        </span>
                    @endif
                </td>
                <td style="width:100px">
                    {{ \Lib::dateFormat($value->created, 'd/m/Y - H:i') }}
                </td>
                @if(\Lib::can($permission, 'edit'))
                <td class="text-right">
                    <a title="Cập nhật thông tin" href="{{ route('admin.'.$key.'.edit', $value->id) }}"
                       class=""> <i class="action-icon mdi mdi-square-edit-outline"></i></a>
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    function _remove(link) {
        Swal.fire(
            {
                title: "Bạn có chắc chắn muốn xóa bản ghi này?",
                text: "Lưu ý: dữ liệu bị xóa sẽ không thể phục hồi lại được!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonClass: "btn btn-success mt-2 btn-sm",
                cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                buttonsStyling: !1,
                confirmButtonText: "Vâng, Tôi muốn xóa!"
            }).then(function (t) {
            if (t.value) {
                return _GET_URL(link);
            }
        });
    }
</script>