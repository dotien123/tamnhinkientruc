@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')

    <section id="card-actions">
        <div class="row">
            <div class="col-12 col-lg-8">

                    {!! Form::open(['url' => route('admin.'.$key.'.edit.post', $data->id)]) !!}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> Thông tin cá nhân </h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="editProfile" value="1" />
                            <input type="hidden" name="active" value="3" />
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fullname">Họ và tên</label>
                                        <input type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" id="fullname" name="fullname" value="{{ old('fullname', $data->fullname) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email </label>
                                        <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email', $data->email) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại </label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $data->phone) }}" required>
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
                        
                                @if($view=='popup')
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
                        
                                @if($preview && @$obj['id'])
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
                        
                        
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                <div class="col-lg-6">
    
                </div>
    
            </div>
        </div>
            <div class="preview"></div>
    </section>
@stop

@push('JS_REGION')
    <script>
         @if (session('status'))
            toastr.options.progressBar = true;
            toastr.info('{!! session('status') !!}');
        @endif
        @if( count($errors) > 0)
            toastr.options.progressBar = true;
            var err = '{!! json_encode($errors->all()) !!}';
            console.log(err);
            toastr.error(JSON.parse(err));
        @endif
    </script>    
@endpush