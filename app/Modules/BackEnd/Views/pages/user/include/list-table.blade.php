
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
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo trạng thái">
                                <select name="status" class="form-control" data-toggle="select2">
                                    <option value="">Chọn trạng thái </option>
                                    @foreach($statusOpt as $k => $v)
                                        <option value="{{ $k }}"{{$search_data->status != '' && $search_data->status == $k ? ' selected="selected"' : ''}}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo quyền hạn">
                                <select id="role" name="role" class="form-control" data-toggle="select2">
                                    <option value="">Quyền hạn</option>
                                    @foreach($roles as $r)
                                        <option value="{{ $r->id }}" {{$search_data->role != '' && $search_data->role == $r->id ? ' selected="selected"' : ''}}>{{ $r->title }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm tên đăng nhập">
                                <input type="text" name="user_name" class="form-control" />
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
                            "Tên đăng nhập",
                            "Thông tin cá nhân",
                            "Vai trò",
                            "Đăng nhập",
                            "Trạng thái",
                            "Ngày ĐK",
                        ] as $k=> $label)
                        <th title="{{$label}}">{{ $label }}@if($k==0)
                                <div><span class="text-danger">({{ @$lsObj->total() }}) bản ghi</span></div>@endif</th>
                    @endforeach
                    <th align="center"></th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($lsObj) || count($lsObj) > 0)
                    @foreach ($lsObj as $k => $user)
                        @if(!$user->isRoot())
                            <tr>
                                <td></td>
                                <td><b>{{ $user->user_name }}</b></td>
                                <td>
                                    <div><b>Name:</b> {{ $user->fullname }}</div>
                                    <div><b>Email:</b> {{ $user->email }}</div>
                                    <div><b>Phone:</b> {{ $user->phone }}</div>
                                </td>
                                <td>
                                    @if(!$user->isRoot())
                                        @foreach($user->roles as $role)
                                            <div class="mb-1 font-weight-bold text-danger">{{ $role->title }}</div>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <div><b>IP:</b> {{ $user->last_login_ip }}</div>
                                    <div><b>Lúc:</b> {{ \Lib::dateFormat($user->last_login, 'd/m/Y H:i:s') }}</div>
                                </td>
                                <td>
                                    <span class="badge users-view-status badge-light-{{ $user->getStatusClass() }}">{{ $user->getStatusText() }}</span>

                                    @if($user->last_logout > 0)
                                        <span title="{{\Lib::dateFormat($user->last_logout, 'd/m/Y')}}">{{ \Lib::dateFormat($user->last_logout, 'H:i:s') }}</span>
                                    @elseif($user->last_active > 0)
                                        <span title="{{\Lib::dateFormat($user->last_active, 'd/m/Y')}}">{{ \Lib::dateFormat($user->last_active, 'H:i:s') }}</span>
                                    @endif

                                </td>
                                <td align="center">{{ \Lib::dateFormat($user->created, 'd/m/Y H:i:s') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if (\Lib::can($permission, 'edit') && ($user->id != \Auth::id()) && (!$user->isRoot() || \Auth::id() == 1) && \Auth::user()->biggerThanYou($user->id))
                                                <a title="Cập nhật thông tin" href="javascript:void(0);" onclick="shop.admin.activeUser({{$user->id}}, {{ $user->active > 0 ? 0 : 1 }})"
                                                   class="dropdown-item"> <i class="menu-livicon mr-1" data-options="name: morph-lock.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"></i>{{ $user->active > 0 ? 'Đã kích hoạt' : 'Chưa kích hoạt' }}</a>
                                            @endif
                                            @if(\Lib::can($permission, 'edit') && ((!$user->isRoot() || \Auth::id() == 1) && \Auth::user()->biggerThanYou($user->id)) || $user->id == \Auth::id())
                                                <a title="Cập nhật thông tin" href="{{ route('admin.'.$key.'.edit', $user->id) }}"
                                                   class="dropdown-item"> <i class="menu-livicon mr-1" data-options="name: pen.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"></i>Chỉnh sửa</a>
                                            @endif
                                            @if(\Lib::can($permission, 'delete'))
                                                <a title="Xóa bản ghi" href="{{ route('admin.'.$key.'.delete', $user->id) }}" onclick="return confirm('Bạn muốn xóa tài khoản')"
                                                   class="dropdown-item"> <i class="menu-livicon mr-1" data-options="name: trash.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;" data-icon="trash"></i>Xóa</a>
                                            @endif
                                            @if(\Lib::can($permission, 'delete'))
                                                <a title="Xem nhật ký hoạt động của {{ \Auth::user()->user_name }}" href="{{ route('admin.'.$key.'.log', $user->id) }}"
                                                   class="dropdown-item"> <i class="menu-livicon mr-1" data-options="name: hammer.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;" data-icon="hammer"></i>Nhật ký hoạt động</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <!-- datatable ends -->
    </div>
</section>
<!-- table checkbox ends -->