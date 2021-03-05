<tr>
    <td align="center">
        <label><input type="checkbox" name="checkbox-item-input[]"  class="checkbox-item-input custome-checkbox check-item" value="{{$d->id}}"><span></span></label>
    </td>
    <td class=" {{ $class }}" colspan="1">

        @if($d->aid > 0) {{-- check cos phải là QT --}}
            <span class="text-italic">Quản trị viên trả lời: </span>
            <span class="text-italic" style="color: orange">{{$d->comment}}</span>
        @elseif($d->getcommentrep($d->action, $d->tableName) != '') {{-- gọi comment QT đã tl --}}
            <div>
                Bình luận của: <span style="color:blue;">{{$d->getcommentrep($d->action, $d->tableName)['customer_name'] }} - {{ $d->getcommentrep($d->action, $d->tableName)['phone'] }}</span><br/>
                <span class="italic">{{ $d->getcommentrep($d->action, $d->tableName)['comment'] }}</span>
            </div>  
        @elseif($d->comment_parent > 0 && $d->getcommentrep($d->action, $d->tableName) == '') {{-- check comment có comment cha --}}
            <div>
                Bình luận của: <span style="color:blue;">{{@$d->parent->customer_name}} - {{$d->parent->phone}}</span><br/>
                <span class="italic">{{@$d->parent->comment}}</span>
            </div>

        @endif

        
        <div>
            <span style="color:blue;">{{ $d->customer_name }} - {{$d->phone}}</span> {!! $d->comment_parent > 0 ? '<span style="color:red;"> Đã trả lời: </span>' : '' !!}<br/>
            <span class="italic" style="color: red">{{@$d->comment}}</span>

        </div>
        
        
    </td>
    <td>{{$d->url}}</td>
    <td>{{ $d->getnameComment($d->tableName) }}</td>
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
                            data-options="name: pen.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"></i>Trả lời</a>
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
