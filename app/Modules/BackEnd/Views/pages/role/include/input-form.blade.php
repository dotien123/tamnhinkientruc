<section id="card-actions">
@if(old_blade('editMode') && \Lib::can($permission, 'edit'))
    @if (@$data->id == 1 || !\Auth::user()->checkMyRank(@$data->rank))
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Cảnh báo!</h4>
        <p>Vì lí do bảo mật nên bạn không thể chỉnh sửa thông tin của <b>{{ @$data->title }}</b></p>
        <hr>
        <p class="mb-0" align="right">
            <a class="btn btn-outline-warning" href="{{ redirect()->back()->getTargetUrl() }}"><i class="fa fa-angle-left"></i>&nbsp; Quay lại</a>
        </p>
    </div>
@else
        @if(old_blade('editMode'))
            {!! Form::open(['url' => route('admin.'.$key.'.edit.post', $data->id), 'class' => 'row', 'files' => true]) !!}
        @else
            {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'class' => 'row', 'files' => true]) !!}
        @endif
        <div class="col-lg-9 col-12">
            @if( count($errors) > 0)
                <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @foreach ($errors->all() as $error)
                        {!! $error !!}
                    @endforeach
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">
                    {!! session('status') !!}
                </div>
            @endif

            <div class="card">
                <ul class="nav nav-tabs nav-bordered nav-justified">
                    <li class="nav-item">
                        <a href="#thong-tin-chi-tiet" data-toggle="tab" aria-expanded="false" class="nav-link text-left active">
                            Thông tin chi tiết
                        </a>
                    </li>
                </ul>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Tên Nhóm</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ old('title', @$data->title) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Độ ưu tiên</label>
                                <input type="text" class="form-control{{ $errors->has('rank') ? ' is-invalid' : '' }}" id="rank" name="rank" value="{{ old('rank', @$data->rank) }}" onkeypress="return shop.numberOnly()" maxlength="4" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @php
                            @$data->permit = json_decode(@$data->permit, true)
                        @endphp
                        @foreach ($roles as $key => $role)
                        <div class="col-sm-3">
                            <div class="card">
                                <ul class="nav nav-tabs nav-bordered nav-justified">
                                    <li class="nav-item">
                                        <a href="#{{ str_slug($role['title']) }}" data-toggle="tab" aria-expanded="false" class="nav-link text-left active">
                                            {{ $role['title'] }}
                                        </a>
                                    </li>
                                </ul>
                                <div class="card-body">
                                    @foreach ($role['perm'] as $k => $title)
                                        <div class="row">
                                            <div class="col-sm-8">{{ $title }}</div>
                                            <div class="col-sm-4">
{{--                                                <label class="switch switch-text switch-pill switch-success">--}}
                                                    <input type="checkbox" class="d-inline-block" name="{{$key}}[]" value="{{ $k }}" @if(isset($data->permit[$key]) && in_array($k, $data->permit[$key]))) checked="checked" @endif>
{{--                                                    <span class="switch-label" data-on="On" data-off="Off"></span>--}}
{{--                                                    <span class="switch-handle"></span>--}}
{{--                                                </label>--}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-control">
            <div class="container-fluid control-item">
                @if(@$obj['id'])
                    {{--@if(is_deleted($obj,false))
                        <a href="javascript:void(0)"
                        onclick="return _revertTask('{!! admin_link('/spk-notification/_delete?id='.$obj['id'].'&revert=true&token='.build_token($obj['id'])) !!}')"
                        class="btn btn-warning waves-effect btn-xs mr-3"><i class="fe-refresh-cw"></i> Khôi phục</a>
                    @else
                        <a href="javascript:void(0)"
                        onclick="return _removeDocument('{!! admin_link('/spk-notification/_delete?id='.$obj['id'].'&token='.build_token($obj['id'])) !!}')"
                        class="btn btn-danger waves-effect btn-xs mr-3"><i class="fe-delete"></i> Xóa</a>
                    @endif--}}
                @endif

                @if(@$view=='popup')
                    <a onclick="_CLOSE_MODAL()" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>

                    @if( @$obj['id'])
                        <a href="{!! admin_link('/spk-notification/input?id='.$obj['_id'].'&preview=1') !!}"
                        class="btn btn-light waves-effect mr-3 btn-xs"><i class="fe-eye"></i> Xem chi tiết </a>
                    @endif

                @else
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>
                @endif

                {{--            @if( @$obj['_id'])--}}
                {{--                <a title="Xem bản in" target="_blank"--}}
                {{--                   href="{!! admin_link('/spk-notification/input?id='.$obj['_id']).'&output=print' !!}"--}}
                {{--                   class="btn btn-light waves-effect mr-3 btn-xs"><i class="mdi mdi-printer"></i> Xem bản in</a>--}}
                {{--            @endif--}}
                @if(\Lib::can($permission, 'edit'))
                    @if(@$preview && @$obj['id'])
                        <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id')) }}"
                        class="btn btn-warning waves-effect mr-3"><i class="fe-edit"></i> Sửa thông tin</a>
                    @else
                        @if( @$obj['id'])
                            <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id').'?preview=1') }}"
                            class="btn btn-light waves-effect mr-3 btn-xs"><i class="fe-eye"></i> Xem chi tiết </a>
                        @endif

                        <button type="submit"
                        class="btn btn-teal-800 waves-effect waves-light mr-3"><i class="fe-save"></i> Cập nhật</button>
                    @endif
                @endif


            </div>
        </div>
        {!! Form::close() !!}
    @endif
@elseif(\Lib::can($permission, 'add'))
    @if(old_blade('editMode'))
        {!! Form::open(['url' => route('admin.'.$key.'.edit.post', $data->id), 'class' => 'row', 'files' => true]) !!}
    @else
        {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'class' => 'row', 'files' => true]) !!}
    @endif
    <div class="col-lg-9 col-12">
        @if( count($errors) > 0)
            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @foreach ($errors->all() as $error)
                    {!! $error !!}
                @endforeach
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {!! session('status') !!}
            </div>
        @endif

        <div class="card">
            <ul class="nav nav-tabs nav-bordered nav-justified">
                <li class="nav-item">
                    <a href="#thong-tin-chi-tiet" data-toggle="tab" aria-expanded="false" class="nav-link text-left active">
                        Thông tin chi tiết
                    </a>
                </li>
            </ul>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="title">Tên Nhóm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" value="{{ old('title', @$data->title) }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="title">Độ ưu tiên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('rank') ? ' is-invalid' : '' }}" id="rank" name="rank" value="{{ old('rank', @$data->rank) }}" onkeypress="return shop.numberOnly()" maxlength="4" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        @$data->permit = json_decode(@$data->permit, true)
                    @endphp
                    @foreach ($roles as $key => $role)
                        <div class="col-sm-3">
                            <div class="card">
                                <ul class="nav nav-tabs nav-bordered nav-justified">
                                    <li class="nav-item">
                                        <a href="#{{ str_slug($role['title']) }}" data-toggle="tab" aria-expanded="false" class="nav-link text-left active">
                                            {{ $role['title'] }}
                                        </a>
                                    </li>
                                </ul>
                                <div class="card-body">
                                    @foreach ($role['perm'] as $k => $title)
                                        <div class="row">
                                            <div class="col-sm-8">{{ $title }}</div>
                                            <div class="col-sm-4">
{{--                                                <label class="switch switch-text switch-pill switch-success">--}}
                                                    <input type="checkbox" class="d-inline-block" name="{{$key}}[]" value="{{ $k }}" @if(isset($data->permit[$key]) && in_array($k, $data->permit[$key]))) checked="checked" @endif>
{{--                                                    <span class="switch-label" data-on="On" data-off="Off"></span>--}}
{{--                                                    <span class="switch-handle"></span>--}}
{{--                                                </label>--}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-control">
        <div class="container-fluid control-item">
            @if(@$obj['id'])
                {{--@if(is_deleted($obj,false))
                    <a href="javascript:void(0)"
                    onclick="return _revertTask('{!! admin_link('/spk-notification/_delete?id='.$obj['id'].'&revert=true&token='.build_token($obj['id'])) !!}')"
                    class="btn btn-warning waves-effect btn-xs mr-3"><i class="fe-refresh-cw"></i> Khôi phục</a>
                @else
                    <a href="javascript:void(0)"
                    onclick="return _removeDocument('{!! admin_link('/spk-notification/_delete?id='.$obj['id'].'&token='.build_token($obj['id'])) !!}')"
                    class="btn btn-danger waves-effect btn-xs mr-3"><i class="fe-delete"></i> Xóa</a>
                @endif--}}
            @endif

            @if(@$view=='popup')
                <a onclick="_CLOSE_MODAL()" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>

                @if( @$obj['id'])
                    <a href="{!! admin_link('/spk-notification/input?id='.$obj['_id'].'&preview=1') !!}"
                       class="btn btn-light waves-effect mr-3 btn-xs"><i class="fe-eye"></i> Xem chi tiết </a>
                @endif

            @else
                <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-light waves-effect btn-xs mr-3">Bỏ qua</a>
            @endif

            {{--            @if( @$obj['_id'])--}}
            {{--                <a title="Xem bản in" target="_blank"--}}
            {{--                   href="{!! admin_link('/spk-notification/input?id='.$obj['_id']).'&output=print' !!}"--}}
            {{--                   class="btn btn-light waves-effect mr-3 btn-xs"><i class="mdi mdi-printer"></i> Xem bản in</a>--}}
            {{--            @endif--}}
            @if(\Lib::can($permission, 'edit'))
                @if(@$preview && @$obj['id'])
                    <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id')) }}"
                       class="btn btn-warning waves-effect mr-3"><i class="fe-edit"></i> Sửa thông tin</a>
                @else
                    @if( @$obj['id'])
                        <a href="{{ route('admin.'.$key.'.edit.post', old_blade('id').'?preview=1') }}"
                           class="btn btn-light waves-effect mr-3 btn-xs"><i class="fe-eye"></i> Xem chi tiết </a>
                    @endif

                    <button type="submit"
                            class="btn btn-teal-800 waves-effect waves-light mr-3"><i class="fe-save"></i> Cập nhật</button>
                @endif
            @endif


        </div>
    </div>
@endif
</section>

