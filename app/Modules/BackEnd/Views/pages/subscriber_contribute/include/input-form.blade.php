
    @if(old_blade('editMode'))
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', $obj->id) , 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'files' => true]) !!}
    @endif
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <ul class="nav nav-tabs nav-bordered nav-justified">
                    <li class="nav-item">
                        <a href="#thong-tin-chi-tiet" data-toggle="tab" aria-expanded="false" class="nav-link text-left active">
                    SỬA THÔNG TIN
                        </a>
                    </li>
                </ul>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="fullname">Họ tên</label>
                                <input type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" id="fullname" name="fullname" value="{{ old('fullname', @$obj->fullname) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email', @$obj->email) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="phone">Điện thoại</label>
                                <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone', @$obj->phone) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-sm-12">
                             <div class="form-group">
                                <label for="phone">Địa chỉ</label>
                                <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" name="address" value="{{ old('phone', @$obj->address) }}" required>
                             </div>
                         </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="money">Số tiền</label>
                                <input type="text" class="form-control text-danger " name="total_money" id="money" value="{{ \Lib::priceFormat(@$obj->total_money , ' VNĐ') }}"  onkeypress="return shop.numberOnly()" onkeyup="mixMoney(this)" onfocus="this.select()" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="sort">Nội dung</label>
                                    <textarea class="form-control" rows="5" name="content" id="product-meta-description" placeholder="Nội dung">{{ old('content', json_decode(@$obj->content)) }}</textarea>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="bottom-control">
            <div class="container-fluid control-item">
                @if(@$obj['id'] && \Lib::can($permission, 'delete'))
                    @if($obj['removed'] == 1)
                        <a href="javascript:void(0)"
                           onclick="shop.admin.revertItem({{ $obj['id'] }}, true, 'subscriber_contribute')"
                           class="btn btn-warning waves-effect btn-xs mr-3"><i class="fe-refresh-cw"></i> Khôi phục</a>
                    @else
                        <a href="javascript:void(0)"
                           onclick="shop.admin.revertItem({{ $obj['id'] }}, false, 'subscriber_contribute')"
                           class="btn btn-danger waves-effect btn-xs mr-3"><i class="fe-delete"></i> Xóa</a>
                    @endif
                @endif

                @if($view=='popup')
                    <a onclick="_CLOSE_MODAL()" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>

                @else
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>
                @endif

                {{--            @if( @$obj['_id'])--}}
                {{--                <a title="Xem bản in" target="_blank"--}}
                {{--                   href="{!! admin_link('/spk-notification/input?id='.$obj['_id']).'&output=print' !!}"--}}
                {{--                   class="btn btn-light waves-effect mr-3 btn-xs"><i class="mdi mdi-printer"></i> Xem bản in</a>--}}
                {{--            @endif--}}

                @if($preview && @$obj['id'])
                    <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id')) }}"
                       class="btn btn-warning waves-effect mr-3"><i class="fe-edit"></i> Sửa thông tin</a>
                @else
                    <button type="submit"
                            class="btn btn-teal-800 waves-effect waves-light mr-3"><i class="fe-save"></i> Cập nhật</button>
                @endif


            </div>
        </div>
    </div>
     {!! Form::close() !!}

<script>
    function mixMoney(myfield) {
        var thousands_sep = '.',
            val = parseInt(myfield.value.replace(/[.*+?^${}()|[\]\\]/g, ''));
        myfield.value = shop.numberFormat(val, 0, '', thousands_sep);
    }
</script>