<section id="table-chechbox">
    <div class="card">
        <div class="card-header">
            <!-- head -->
            <h5 class="card-title">
                Danh sách {{ @$site_title }}
                <span>
                    <a href="{{ route('admin.'.$key.'.add.post') }}" class="btn btn-info " data-overlaycolor="#38414a">
                         Thêm mới
                    </a>
                </span>
            </h5>
            <form id="search">
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo ngày xuất bản">
                                <input style="width: 200px;" autocomplete="off" type="text" name="time_between" value="{{ $search_data->time_between }}" class="form-control range-datepicker" placeholder="Chọn ngày xuất bản"/>
                                <div class="form-control-position">
                                    <i class="bx bx-calendar font-medium-1"></i>
                                </div>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm Tên nhóm">
                                <input type="text" name="fullname" class="form-control" value="{{ $search_data->fullname }}" placeholder="Tên nhóm" />
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
            <table class="table table-centered table-striped" id="products-datatable" class="table table-transparent">
                <thead>
                <tr>
                    <th style="width: 20px;">
                        {{--<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                        </div>--}}
                    </th>
                    @foreach([
                    "Tên nhóm",
                    "Xếp hạng",
                    "Quyền hạn",
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
                @foreach($lsObj as $k => $item)
                    <tr>
                        <td class="td-number ribbon-box">
                            <span class="">
                            {{str_pad($k+1, 2, '0', STR_PAD_LEFT)}}
                            </span>
                        </td>
                        <td style="width:100px">
                            <a href="javascript:void(0);" title="{{ @$item->title }}" class="font-weight-bold d-block">
                                {{ \StringLib::getStrVal(@$item->title) }}
                            </a>
                        </td>
                        <td >{{ $item->rank }}</td>
                        <td>
                            @if($item->id == 1)
                                <b class="text-danger">--- ALL ---</b>
                            @elseif(!empty($item->permit))
                                <a data-toggle="collapse" href="#role{{ $item->id }}" role="button" aria-expanded="false" aria-controls="role{{ $item->id }}">
                                    Chi tiết quyền</a>
                                <div class="collapse" id="role{{ $item->id }}">
                                    <div class="card card-body">
                                        @php($item->permit = json_decode($item->permit, 1))
                                        @foreach($item->permit as $k => $val)
                                            @php($val = implode(' - ', $val))
                                            <p><b>{{ $k }}:</b> <span class="text-success">{{ $val }}</span></p>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>{{ \Lib::dateFormat($item->created, 'd/m/Y') }}</td>
                        <td>
                            <div class="dropdown">
                            <span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                            </span>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @if(\Lib::can($permission, 'edit'))
                                        @if($item->id != 1 && \Auth::user()->checkMyRank($item->rank))
                                            <a title="Cập nhật thông tin" href="{{ route('admin.'.$key.'.edit', $item->id) }}"
                                               class="dropdown-item"><i class="menu-livicon mr-1" data-options="name: pen.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"></i>Chỉnh sửa</a>
                                        @endif
                                    @endif
                                    @if(\Lib::can($permission, 'delete'))
                                        @if($item->id != 1 && \Auth::user()->checkMyRank($item->rank))
                                            <a title="Xóa bản ghi" href="{{ route('admin.'.$key.'.delete', $item->id) }}"
                                               class="dropdown-item" onclick="return confirm('Bạn muốn xóa quyền này ?')"><i class="menu-livicon mr-1" data-options="name: trash.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;" data-icon="trash"></i>Xóa</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <div class="preview"></div>
    </div>
</section>

