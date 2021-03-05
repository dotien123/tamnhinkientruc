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
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo loại bài">
                                <select name="type" class="form-control" data-toggle="select2">
                                    <option value="">Chọn loại bài </option>
                                    @foreach($type as $k => $v)
                                        <option value="{{ $k }}" {{ $search_data->type == $k ? ' selected="selected"' : '' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo trạng thái">
                                <select name="status" class="form-control" data-toggle="select2">
                                    <option value="">Chọn trạng thái </option>
                                    <option value="1"{{ $search_data->status == 1 ? ' selected="selected"' : '' }}>Đã đăng</option>
                                    <option value="0"{{ $search_data->status == '0' ? ' selected="selected"' : '' }}>Chờ xét duyệt</option>
                                </select>
                            </fieldset>
                        </li>
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
        @if(empty($data) || $data->isEmpty())
            <div class="alert alert-danger" role="alert">
                <i class="mdi mdi-block-helper mr-2"></i>
                Không tìm thấy dữ liệu nào ở trang này. (Hãy kiểm tra lại các điều kiện tìm kiếm hoặc phân trang...)
            </div>
        @else
            <div class="table-responsive">
                <div class="d-none" id="popup-action">
                    <div class="show">
                        <a href="javascript:void(0)" class="btn btn-danger mb-3 text-light mt-2 ml-2" onclick="shop.admin.checkAllAction('page_intro', 'status', -1)" title="Xóa tất cả bản ghi đã chọn">Xóa</a>
                    </div>
                </div>
                <table id="table-extended-chechbox" class="table table-transparent">
                    <thead>
                    <tr>
                        <th width="20" class="text-center">
                            <label><input type="checkbox"  class="checkbox-all-item-input custome-checkbox"><span></span></label>
                        </th>
                        @foreach([
                            "Tên",
                            'Link',
                            "Trạng thái",
                            "Ngày xuất bản"
                        ] as $k=> $label)
                            <th title="{{$label}}">{{ $label }}@if($k==0)
                                    <div><span class="text-danger">({{ @$data->total() }}) bản ghi</span></div>@endif</th>
                        @endforeach
                        <th style="width: 20px;text-align: right">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k=>$value)
                        <tr>
                            <td align="center">
                                <label><input type="checkbox" name="checkbox-item-input[]"  class="checkbox-item-input custome-checkbox check-item" value="{{$value->id}}"><span></span></label>
                            </td>
                            <td class="text-bold-600 pl-0" style="width:150px">
                                {{ \StringLib::getStrVal(@$value['title'])}}
                            </td>
                            <td style="width:250px">
                            <a href="{{ route('introduce.detail',['alias' => @$value['alias'], 'id' => @$value->id]) }}" target="_blank">
                                {{ @$value['alias'] }}
                            </a>
                            </td>
                            <td style="width:20px">
                                @if($value->status == \App\Models\PageIntro::STATUS_ACTIVE)
                                    <span class="badge badge-success badge-pill">Đã đăng</span>
                                @elseif($value->status == \App\Models\PageIntro::STATUS_INACTIVE)
                                    <span class="badge badge-warning badge-pill">Chờ xét duyệt</span>
                                @endif
                            </td>
                            <td style="width:50px">
                                {{ \Lib::dateFormat($value->published, 'd/m/Y - H:i') }}
                            </td>
                            <td class="text-right">
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
        @endif
    </div>
    <!--- end row -->
</section>
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