<tr>

    <td class="alert-secondary"@if($sort_col > 1) colspan="{{ $sort_col }}" align="right"@endif>
        <strong>{{ $d->sort }}</strong>
    </td>
    <td class="font-weight-bold {{ $class }}" colspan="{{ $title_col }}">{{ $d->title }}</td>
    <td>
        @if(!empty($d->link) || !empty($d->alias))
            <a href="{{ $d->alias ? $d->alias  : $d->getLink() }}" target="_blank">{{ $d->alias ? $d->alias : $d->link }}</a>
        @else
            ---
        @endif
    </td>
    <td>
        <div class="switchery-demo text-center">
            <input type="checkbox" data-plugin="switchery" data-id="{{ $d->id }}" data-value="{{ $d->status }}" data-color="#00695c" @if($d->status) checked @endif data-size="small"/>
        </div>
    </td>
    {{-- <td align="center">
        @if($d->newtab == 1)
            <i class="fa fa-thumbs-up text-success"></i>
        @else
            <i class="fa fa-thumbs-down text-danger"></i>
        @endif
    </td>
    <td align="center">
        @if($d->no_follow == 1)
            <i class="fa fa-thumbs-down text-danger"></i>
        @else
            <i class="fa fa-thumbs-up text-success"></i>
        @endif
    </td> --}}
    <td>{{ \Lib::dateFormat($d->created, 'd/m/Y') }}</td>
    <td>
        <div class="dropdown">
            <span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
            </span>
            <div class="dropdown-menu dropdown-menu-right">
                @if(\Lib::can($permission, 'edit'))
                    <a title="Cập nhật thông tin" href="{{ route('admin.'.$key.'.edit', $d->id) }}"
                       class="dropdown-item"> <i class="menu-livicon mr-1" data-options="name: pen.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"></i>Chỉnh sửa</a>
                @endif
                @if(\Lib::can($permission, 'delete'))
                    <a title="Xóa bản ghi" href="{{ route('admin.'.$key.'.delete', $d->id) }}"
                       class="dropdown-item xoa-ban-ghi"> <i class="menu-livicon mr-1" data-options="name: trash.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;" data-icon="trash"></i>Xóa</a>
                @endif
            </div>
        </div>
    </td>
</tr>