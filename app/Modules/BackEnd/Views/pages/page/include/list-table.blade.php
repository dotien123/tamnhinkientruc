<section id="table-chechbox">
    <div class="card">
            <div class="card-header">
                <!-- head -->
                <h5 class="card-title">
                    Danh sách trang tĩnh
                    <span>
                        <a href="{{ route('admin.'.$key.'.add.post') }}" class="btn btn-info fix-add-btn" data-overlaycolor="#38414a">
                        Thêm mới
                        </a>
                        </span>
                </h5>
                <form id="search">
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo trạng thái">
                                    <select name="status" class="form-control" data-toggle="select2">
                                        <option value="">Chọn trạng thái </option>
                                        <option value="1"{{ $search_data->status == 1 ? ' selected="selected"' : '' }}>Đã đăng</option>
                                        <option value="0"{{ $search_data->status == '0' ? ' selected="selected"' : '' }}>Chờ xét duyệt</option>
                                        <!--<option value="-1"{{ $search_data->status == -1 ? ' selected="selected"' : '' }}>Deleted</option>-->
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
            <div class="table-responsive">
                <div class="d-none" id="popup-action">
                    <div class="show">
                        <a href="javascript:void(0)" class="btn btn-danger mb-3 text-light mt-2 ml-2" onclick="shop.admin.checkAllAction('page', 'status', -1)" title="Xóa tất cả bản ghi đã chọn">Xóa</a>
                    </div>
                </div>
                <table id="table-extended-chechbox" class="table table-transparent">
                    <thead>
                    <tr>
                        <th width="20" class="text-center">
                            <label><input type="checkbox"  class="checkbox-all-item-input custome-checkbox"><span></span></label>
                        </th>
                        </th>
                        @foreach([
                        "Tiêu đề",
                        // "Link",
                        // "Loại bài",
                        "Trạng thái",
                        "Ngày xuất bản",
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
                        <th style="width: 20px;text-align: right">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k=>$value)
                        <tr>
                            <td align="center">
                                <label><input type="checkbox" name="checkbox-item-input[]"  class="checkbox-item-input custome-checkbox check-item" value="{{$value->id}}"><span></span></label>
                            </td>
                            {{-- <td class="td-number ribbon-box">
                                <span>
                                {{str_pad($k+1, 2, '0', STR_PAD_LEFT)}}
                                </span>
                            </td> --}}
                            <td class="text-bold-600 pl-0">
                                {{ \StringLib::getStrVal(@$value['title'])}}
                            </td>
{{--                            <td >--}}
{{--                                <a href="{{ route('introduce.detail',['alias' => $value->alias]) }}">{{route('introduce.detail',['alias' => $value->alias])}}</a>--}}
{{--                                <a href="{{ public_link('page/'.$value->alias).'.htm'}}" target="_blank">{{env('APP_URL').'/page/'.@$value['alias'].'.htm'}}</a>--}}
{{--                            </td>--}}
                            {{-- <td>
                                @if($value->type == 0)
                                    <span class="badge badge-success badge-pill">Mua trả góp</span>
                                @elseif($value->type == 1)
                                    <span class="badge badge-warning badge-pill">Về chúng tôi</span>
                                @elseif($value->type == 2)
                                    <span class="badge badge-danger badge-pill">Bảng giá</span>
                                @else
                                    <span class="badge badge-secondary badge-pill">Vì sao chọn chúng tôi</span>
                                @endif
                            </td> --}}
                            <td style="width:20px">
                                @if($value->status == 1)
                                    <span class="badge badge-success badge-pill">Đã đăng</span>
                                @elseif($value->status == 0)
                                    <span class="badge badge-warning badge-pill">Chờ xét duyệt</span>
                                @elseif($value->status == -2)
                                    <span class="badge badge-secondary badge-pill">Bản nháp</span>
                                @elseif($value->status == -1)
                                    <span class="badge badge-danger badge-pill">Deleted</span>
                                @endif
                            </td>
                            <td >
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
                                            <a title="Xóa bản ghi" href="{{ route('admin.'.$key.'.delete', $value->id) }}" onclick="return confirm('Bạn muốn xóa bản ghi?')"
                                               class="dropdown-item"> <i class="menu-livicon mr-1" data-options="name: trash.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;" data-icon="trash"></i>Xóa</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if(empty($data) || $data->isEmpty())
                <h4 align="center">Không tìm thấy dữ liệu phù hợp</h4>
            @else
                {!! $data->links('BackEnd::layouts.pagin', ['data' => $data]) !!}
            @endif
        </div>
</section>
