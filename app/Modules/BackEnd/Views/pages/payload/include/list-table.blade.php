<tr>
    <td align="center">
        <label><input type="checkbox" name="checkbox-item-input[]"  class="checkbox-item-input custome-checkbox check-item" value="{{$item->id}}"><span></span></label>
    </td>
    <td class="font-weight-bold {{ $class }}" colspan="1">{{ $d->title }}</td>

    <td style="width:110px">
        <div class="switchery-demo text-center">
            <input type="checkbox" data-plugin="switchery" data-id="{{ $d->id }}" data-value="{{ $d->status }}"
                data-color="#00695c" @if ($d->status) checked @endif
            data-size="small"/>
        </div>
    </td>
    <td align="center">{{ \Lib::dateFormat($d->created, 'd/m/Y') }}</td>

    <td>
        <div class="dropdown">
            <span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
            </span>
            <div class="dropdown-menu dropdown-menu-right">
                @if (\Lib::can($permission, 'edit'))
                    <a title="Cập nhật thông tin" href="{{ route('admin.' . $key . '.edit', $d->id) }}"
                        class="dropdown-item"> <i class="menu-livicon mr-1"
                            data-options="name: pen.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"></i>Chỉnh
                        sửa</a>
                @endif
                @if (\Lib::can($permission, 'delete'))
                    <a title="Xóa bản ghi" href="{{ route('admin.' . $key . '.delete', $d->id) }}"
                        class="dropdown-item xoa-ban-ghi"> <i class="menu-livicon mr-1"
                            data-options="name: trash.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"
                            data-icon="trash"></i>Xóa</a>
                @endif
            </div>
        </div>
    </td>
</tr>
