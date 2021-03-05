<!-- table checkbox start -->
<section id="table-chechbox">
    <div class="card">
        <div class="card-header">
            <!-- head -->
            <h5 class="card-title">
                Danh sách {{ @$site_title }}
                <span>
                    <a href="{{ route('admin.'.$key.'.add.post') }}" class="btn btn-info fix-add-btn" data-overlaycolor="#38414a">
                         Thêm mới
                    </a>
                </span>
            </h5>
            <!-- Single Date Picker and button -->
            <form id="search">
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="HIển thị trong trang dịch vụ">
                                <select name="show_on_service_idx" class="form-control" data-toggle="select2">
                                    <option value="-1" {{ $search_data->show_on_service_idx == -1 ? ' selected="selected"' : '' }}>--Hiển thị trong trang dịch vụ-- </option>
                                    <option value="1"{{ $search_data->show_on_service_idx == 1 ? ' selected="selected"' : '' }}>Có hiện trang dịch vụ</option>
                                    <option value="0"{{ $search_data->show_on_service_idx == 0  ? ' selected="selected"' : '' }}>Không hiện trang dịch vụ</option>
                                </select>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo trạng thái">
                                <select name="status" class="form-control" data-toggle="select2">
                                    <option value="">Chọn trạng thái </option>
                                    <option value="1"{{ $search_data->status == 1 ? ' selected="selected"' : '' }}>Đã đăng</option>
                                    <!--<option value="-2"{{ $search_data->status == -2 ? ' selected="selected"' : '' }}>Bản nháp</option>-->
                                    <option value="0"{{ $search_data->status == '0' ? ' selected="selected"' : '' }}>Chờ xét duyệt</option>
                                </select>
                            </fieldset>
                        </li>
                        {{-- <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo trạng thái">
                                <select id="cat_id" name="type" class="form-control" data-toggle="select2">
                                    <option value=""> Chọn danh mục</option>
                                    @foreach ($catOpt as $v)
                                        <option value="{{ $v['id'] }}" {{ $search_data->type==$v['id'] ? 'selected="selected"' : '' }}>{{ $v['title'] }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </li> --}}
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo ngày xuất bản">
                                <input style="width: 200px;" autocomplete="off" type="text" name="time_between" value="{{ $search_data->time_between }}" class="form-control range-datepicker" placeholder="Chọn ngày xuất bản"/>
                                <div class="form-control-position">
                                    <i class="bx bx-calendar font-medium-1"></i>
                                </div>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm tên bản ghi">
                                <input type="text" name="title" class="form-control" />
                                <div class="form-control-position">
                                    <i class="bx bxl-amazon font-medium-1"></i>
                                </div>
                            </fieldset>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
        <!-- datatable start -->
        <div class="table-responsive">
            <div class="d-none" id="popup-action">
                <div class="show">
                    <a href="javascript:void(0)" class="btn btn-danger mb-3 text-light mt-2 ml-2" onclick="shop.admin.checkAllAction('service', 'status', -1)" title="Xóa tất cả bản ghi đã chọn">Xóa</a>
                </div>
            </div>
            <table id="table-extended-chechbox" class="table table-transparent">
                <thead>
                <tr>
                    <th width="20" class="text-center">
                        <label><input type="checkbox"  class="checkbox-all-item-input custome-checkbox"><span></span></label>
                    </th>
                    @foreach([
                            "Hình ảnh",
                            "Tên",
                            "Trạng thái",
                            "Ngày xuất bản"
                        ] as $k=> $label)
                        <th title="{{$label}}">{{ $label }}
                            {{-- @if($k==0)
                                <div><span class="text-danger">({{ @$lsObj->total() }}) bản ghi</span></div>
                            @endif --}}
                        </th>
                    @endforeach
                    <th align="center" style="width: 20px;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lsObj as $k=>$value)
                <tr>
                    <td align="center">
                        <label><input type="checkbox" name="checkbox-item-input[]"  class="checkbox-item-input custome-checkbox check-item" value="{{$value->id}}"><span></span></label>
                    </td>
                    <td style="width: 100px">
                        <img class="col" src="{{ isset($value->image) ? $value->getImageUrl('image', 'service', 'original') : '' }}" alt="avatar" >
                    </td>
                    <td class="text-bold-600 pl-0" style="width: 350px">
                        {{ $value->title }}
                    </td>
                    
                    <td style="width:120px">
                        @if($value->status == \App\Models\ServiceNew::STATUS_ACTIVE)
                            <span class="text-success">Đã đăng</span>
                        @elseif($value->status == \App\Models\ServiceNew::STATUS_INACTIVE)
                            <span class="text-warning">Chờ xét duyệt</span>
                        @elseif($value->status == \App\Models\ServiceNew::STATUS_DRAFF)
                            <span class="text-secondary">Bản nháp</span>
                        @elseif($value->status == -1)
                            <span class="text-danger">Deleted</span>
                        @endif
                    </td>
                    <td style="width:150px">
                        {{ \Lib::dateFormat($value->published, 'd/m/Y - H:i') }}
                    </td>
                    <td>
                        <div class="dropdown">
                            <span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                            </span>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if(\Lib::can($permission, 'edit'))
                                    <a title="Cập nhật thông tin" href="{{ route('admin.'.$key.'.edit', $value->id) }}"
                                       class="dropdown-item"> <i class="menu-livicon mr-1" data-options="name: pen.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"></i>Chỉnh sửa</a>
                                @endif
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
        <!-- datatable ends -->
    </div>
</section>
<!-- table checkbox ends -->
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