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
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm tên sản phẩm">
                                <input type="text" name="title" class="form-control" />
                                <div class="form-control-position">
                                    <i class="bx bxl-amazon font-medium-1"></i>
                                </div>
                            </fieldset>
                        </li>

                        {{-- <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo thương hiệu">
                                <select id="bran_id" name="brand" class="form-control" data-toggle="select2">
                                    <option value=""> Chọn thương hiệu</option>
                                    @foreach ($lsbr as $v)
                                        <option value="{{ $v['id'] }}" {{ $search_data->brand == $v['id'] ? 'selected="selected"' : '' }}>{{ $v['title'] }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo dòng xe">
                                <select id="cat_id" name="type" class="form-control" data-toggle="select2">
                                    <option value=""> Chọn dòng xe</option>
                                    @foreach ($catOpt as $v)
                                        <option value="{{ $v['id'] }}" {{ $search_data->type == $v['id'] ? 'selected="selected"' : '' }}>{{ $v['title'] }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo trạng thái">
                                <select name="tinh_trang" class="form-control" data-toggle="select2">
                                    <option value="">Tình trạng xe</option>
                                    @foreach($tt as $item)
                                        <option {{ $search_data->tinh_trang == $item['id'] ? 'selected="selected"' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </li>

                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo loại sản phẩm">
                                <select name="accessory" class="form-control" data-toggle="select2">
                                    <option value="-1">Tất cả</option>
                                    <option {{ $search_data->accessory == 1 ? 'selected' : ''}} value="1">Phụ tùng</option>
                                    <option {{ $search_data->accessory == 0 ? 'selected' : ''}} value="0">Sản phẩm</option>
                                </select>
                            </fieldset>
                        </li> --}}
                    </ul>
                </div>
            </form>
        </div>
        <!-- datatable start -->
        <div class="table-responsive">
            <div class="d-none" id="popup-action">
                <div class="show">
                    <a href="javascript:void(0)" class="btn btn-danger mb-3 text-light mt-2 ml-2" onclick="shop.admin.checkAllAction('product', 'status', -1)" title="Xóa tất cả bản ghi đã chọn">Xóa</a>
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
                            "Tên dự án",
                            // "Thương hiệu",
                            // "Tình trạng xe",
                            // "Khuyến mãi",
                            "Ngày tạo"
                        ] as $k=> $label)
                        <th title="{{$label}}">{{ $label }}
                            {{-- @if($k==0)
                                <div><span class="text-danger">({{ @$lsObj->total() }}) bản ghi</span></div>@endif --}}
                            </th>
                    @endforeach
                    <th align="center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lsObj as $k=>$value)
                <tr>
                    <td align="center">
                        <label><input type="checkbox" name="checkbox-item-input[]"  class="checkbox-item-input custome-checkbox check-item" value="{{$value->id}}"><span></span></label>
                    </td>
                    {{-- <td style="width: 20px"></td> --}}
                    <td class="text-bold-600 pl-0 sp-line-3" style="width: 150px;">
                        <img class="col" src="{{ isset($value->image) ? $value->getImageUrl('image', 'product', 'original') : '' }}" alt="avatar" >
                    </td>
                    <td>
                        {{ $value->title }}
                    </td>

                    {{-- <td>
                        {{ @$value->brand->title }}
                    </td>

                    <td style="width:120px">
                        {{ @$value->TitleStatus($value->tt_id) }}
                    </td>

                    <td>{{ $value->sale }}</td> --}}
                    <td style="width:150px">
                        {{ \Lib::dateFormat($value->created, 'd/m/Y - H:i') }}
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
    @if(session('status'))
        toastr.options.progressBar = true;
    toastr.info('Bài viết đã được thêm mới.');
    @endif
            @if(count($errors) > 0)
        toastr.options.progressBar = true;
    var err = '{!! json_encode($errors->all()) !!}';
    toastr.error(JSON.parse(err));

    @endif

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