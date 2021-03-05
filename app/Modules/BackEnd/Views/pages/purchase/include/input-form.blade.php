<div class="row">
    <div class="col-sm-6">
        @if(old_blade('editMode'))
            {!! Form::open(['url' => route('admin.'.$key.'.edit.post', $data->id)]) !!}
        @else
            {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'files' => true]) !!}
        @endif
        <div class="card">
            <ul class="nav nav-tabs nav-bordered nav-justified">
                <li class="nav-item">
                    <a href="#thong-tin-chi-tiet" data-toggle="tab" aria-expanded="false" class="nav-link text-left active">
                SỬA THÔNG TIN
                    </a>
                </li>
            </ul>
            <div class="card-body">
                @if( count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{!! $error !!}</div>
                        @endforeach
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {!! session('status') !!}
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="fullname">Họ tên</label>
                            <input type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" id="fullname" name="fullname" value="{{ old('fullname', @$data->fullname) }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email', @$data->email) }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="phone">Điện thoại</label>
                            <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone', @$data->phone) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="sort">Nội dung</label>
                                <textarea class="form-control" rows="5" name="content" id="product-meta-description" placeholder="Nội dung">{{ old('content', json_decode(@$data->content)) }}</textarea>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fe-send"></i> Cập nhật</button>
                <a class="btn btn-sm btn-danger" href="{{ redirect()->back()->getTargetUrl() }}"><i class="fa fa-ban"></i> Hủy bỏ</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>