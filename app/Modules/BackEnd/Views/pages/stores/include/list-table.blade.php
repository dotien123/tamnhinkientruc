<!-- table checkbox start -->
<section id="table-chechbox">
    <div class="card">
        <div class="card-header">
            <!-- head -->
            <h5 class="card-title">
                {{ @$site_title }}
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
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo trạng thái">
                                <select name="status" class="form-control" data-toggle="select2">
                                    <option value="">Chọn trạng thái </option>
                                    <option value="2"{{ $search_data->status == 2 ? ' selected="selected"' : '' }}>Đã đăng</option>
                                    <option value="0"{{ $search_data->status == '0' ? ' selected="selected"' : '' }}>Chờ xét duyệt</option>
                                    <!--<option value="-1"{{ $search_data->status == -1 ? ' selected="selected"' : '' }}>Deleted</option>-->
                                </select>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo Tỉnh thành">
                                    <select id="province_id" name="province_id" class="form-control"
                                            onchange="shop.admin.getDistrictsByProvinceId('stores')">
                                        <option value="">-- Tỉnh/ Thành phố --</option>
                                        @foreach($provinces as $k => $v)
                                            <option value="{{ $v->id }}"
                                                    @if($search_data->province_id == $v->id) selected="selected" @endif>{{ $v->Name_VI }}
                                            </option>
                                        @endforeach
                                    </select>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo Quận/ Huyện">
                                    <select id="district_id" name="district_id" class="form-control">
                                        <option value="">-- Quận/ Huyện --</option>
                                    </select>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo tên cửa hàng">
                                <input type="text" name="name_store" class="form-control" placeholder="Chọn tên cửa hàng" />
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
            <table id="table-extended-chechbox" class="table table-transparent">
                <thead>
                <tr>
                    <th></th>
                    @foreach([
                            "Tên cửa hàng",
                            "Số điện thoại",
                            "Địa chỉ cửa hàng",
                            "Trạng thái",
                        ] as $k=> $label)
                        <th title="{{$label}}">{{ $label }}@if($k==0)
                                <div><span class="text-danger">({{ @$data->total() }}) bản ghi</span></div>@endif</th>
                    @endforeach
                    <th style="text-align: right">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $k=>$value)
                    <tr>
                        <td></td>
                        <td class="text-bold-600 pl-0">
                            {{ \StringLib::getStrVal($value->name_store) }}
                        </td>
                        <td>
                            {{ $value->phone }}
                        </td>
                        <td>
                            {{ $value->address }}
                        </td>
                        <td style="width:120px">
                            @if($value->status == \App\Models\Stores::STATUS_ACTIVE)
                                <span class="badge badge-success badge-pill">Đã đăng</span>
                            @elseif($value->status == \App\Models\Stores::STATUS_INACTIVE)
                                <span class="badge badge-warning badge-pill">Chờ xét duyệt</span>
                            @elseif($value->status == -1)
                                <span class="badge badge-danger badge-pill">Deleted</span>
                            @endif
                        </td>
                        <td style="text-align: right">
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
@push('JS_PLUGINS_REGION')
    <script>
        $(document).ready(function () {
            let province_id = $('select[name="province_id"]').val();
            if (province_id !== '') {
                shop.admin.getDistrictsByProvinceId('stores', {{$search_data->district_id}});
            }
        });
    </script>
@endpush
