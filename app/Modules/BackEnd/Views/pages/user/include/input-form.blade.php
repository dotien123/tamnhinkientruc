<!-- users edit start -->
<section class="users-edit">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <ul class="nav nav-tabs mb-2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab"
                           href="#account" aria-controls="account" role="tab" aria-selected="true">
                            <i class="bx bx-user mr-25"></i><span class="d-none d-sm-block">Tài khoản</span>
                        </a>
                    </li>
                    @if(old_blade('editMode'))
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" id="information-tab" data-toggle="tab"
                           href="#information" aria-controls="information" role="tab" aria-selected="false">
                            <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">Thông tin cá nhân</span>
                        </a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
                        <!-- users edit media object start -->
                        <div class="media mb-2">
                            <a class="mr-2" href="#">
                                <img id="users-avatar" src="{{ \ImageURL::getImageUrl(@$obj->avatar, 'user', 'medium') }}" alt="{{ @$obj->fullname }}"
                                     class="users-avatar-shadow user-avatar rounded-circle" height="64" width="64">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Avatar</h4>
                                <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                    <label for="select-files" class="btn btn-sm btn-light-primary mb-sm-0">
                                        <span>Thay ảnh đại diện</span>
                                        <input id="select-files" type="file" name="avatar" form="accountForm" hidden>
                                    </label>
                                </div>
                                <p class="text-muted mt-50"><small>Cho phép JPG, GIF hoặc PNG. Kích thước tối đa 800kB</small></p>
                            </div>
                        </div>
                        <!-- users edit media object ends -->
                        <!-- users edit account form start -->
                        @if(old_blade('editMode'))
                            {!! Form::open(['url' => route('admin.'.$key.'.edit.post', $obj->id), 'files' => true, 'novalidate', 'id' => 'accountForm']) !!}
                        @else
                            {!! Form::open(['url' => route('admin.'.$key.'.add.post'), 'files' => true, 'novalidate', 'id' => 'accountForm']) !!}
                        @endif
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'Nhập họ và tên','field'=>[
                                            'label'=>'Họ và tên','key'=>'fullname', 'name' => 'fullname', 'id' => 'fullname', 'class' => 'placement', 'note' => '*', 'classNote' => 'text-danger',
                                            'attr' => [
                                                ['key' => 'maxlength', 'value' => '160'],
                                                ['key' => 'required', 'value' => 'required'],
                                                ['key' => 'data-validation-required-message', 'value' => 'Họ tên không được để trống.'],
                                            ]
                                        ],
                                    ])
                                    <input type="hidden" value="{{ @$obj->id  }}" name="user_id">
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'Nhập email', 'field'=>[ 'type' => 'email',
                                            'label'=>'Email','key'=>'email', 'name' => 'email', 'id' => 'email', 'class' => 'placement', 'note' => '*', 'classNote' => 'text-danger',
                                            'attr' => [
                                                ['key' => 'maxlength', 'value' => '160'],
                                                ['key' => 'required', 'value' => 'required'],
                                                ['key' => 'data-validation-required-message', 'value' => 'Email không được để trống.'],
                                                ['key' => 'data-validation-email-message', 'value' => 'Email không đúng định dạng.'],
                                            ]
                                        ],
                                    ])


                                </div>
                                <div class="col-12 col-sm-6">
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'Tên đăng nhập','field'=>[
                                            'label'=>'Tên đăng nhập', 'name' => 'user_name', 'key' => 'user_name', 'id' => 'user_name', 'class' => 'placement', 'note' => '*', 'classNote' => 'text-danger',
                                            'attr' => [
                                               ['key' => 'maxlength', 'value' => '160'],
                                               ['key' => 'required', 'value' => 'required'],
                                               ['key' => 'data-validation-required-message', 'value' => 'Tên đăng nhập không được để trống.'],
                                            ]
                                        ],
                                    ])
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'Mật khẩu','field'=>[
                                            'label'=>'Mật khẩu', 'name' => 'password', 'id' => 'password', 'class' => 'placement',
                                            'attr' => [
                                               ['key' => 'maxlength', 'value' => '160'],
                                               ['key' => 'autocomplete', 'value' => 'off'],
                                            ]
                                        ],
                                    ])
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'Nhập lại mật khẩu','field'=>[ 'type' => 'password',
                                            'label'=>'Nhập lại mật khẩu','key'=>'password_confirm', 'name' => 'password_confirm',
                                             'id' => 'password_confirm', 'class' => 'placement',
                                            'attr' => [
                                               ['key' => 'maxlength', 'value' => '160'],
                                               ['key' => 'autocomplete', 'value' => 'off'],
                                            ]
                                        ],
                                    ])
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mt-1">
                                            <thead>
                                            <tr>
                                                <th>Phân quyền</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        @foreach($roles as $r)
                                                            <div class="checkbox mb-2 col-2">
                                                                <input type="checkbox" id="checkbox{{ $r->id }}" name="roles[]" value="{{ $r->id }}"
                                                                @if(!old_blade('editMode'))
                                                                    @php($user_roles = old('roles', []))
                                                                            {{ in_array($r->id, $user_roles)?' checked':'' }}
                                                                        @else
                                                                    {{ $user_roles->contains('rid', $r->id)?' checked':'' }}
                                                                        @endif
                                                                        {{ !\Auth::user()->checkMyRank($r->rank)?' disabled':'' }}>
                                                                <label for="checkbox{{ $r->id }}">
                                                                    {{ $r->title }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Lưu thay đổi</button>
                                    <button type="reset" class="btn btn-light">Bỏ qua</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        <!-- users edit account form ends -->
                    </div>
                    <div class="tab-pane fade show" id="information" aria-labelledby="information-tab" role="tabpanel">
                        <!-- users edit Info form start -->
                        @if(old_blade('editMode'))
                            {!! Form::open(['url' => route('admin.'.$key.'.edit.information', $obj->id), 'files' => true, 'novalidate']) !!}
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <h5 class="mb-1"><i class="bx bx-link mr-25"></i>Mạng xã hội</h5>
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'https://www.twitter.com/','field'=>[
                                            'label'=>'Twitter','key'=>'twitter', 'name' => 'twitter', 'id' => 'twitter',
                                        ],
                                    ])
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'https://www.facebook.com/','field'=>[
                                            'label'=>'Facebook', 'key'=>'facebook', 'name' => 'facebook', 'id' => 'facebook',
                                        ],
                                    ])
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'Google+','field'=>[
                                            'label'=>'Google+', 'key'=>'google_plus', 'name' => 'google_plus', 'id' => 'google_plus',
                                        ],
                                    ])
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'https://www.instagram.com/','field'=>[
                                            'label'=>'Instagram', 'key'=>'instagram', 'name' => 'instagram', 'id' => 'instagram',
                                        ],
                                    ])
                                </div>
                                <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                    <h5 class="mb-1"><i class="bx bx-user mr-25"></i>Thông tin cá nhân</h5>
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'Ngày sinh',
                                        'group' => [
                                            'class' => 'position-relative'
                                        ],
                                        'field'=>[
                                            'label'=>'Ngày sinh', 'key'=>'birthdate', 'name' => 'birthdate', 'id' => 'birthdate', 'class' => 'birthdate-picker'
                                        ],
                                    ])
                                    <div class="form-group">
                                        <label>Languages</label>
                                        <select class="form-control" name="languages[]" data-toggle="select2" id="users-language-select2" multiple="multiple">
                                            @php($languages = ['English', 'Spanish', 'French', 'Russian', 'German', 'Arabic', 'Sanskrit'])
                                            @foreach($languages as $language)
                                                <option value="{{ $language }}" {{ (array_search($language, json_decode(@$obj->languages)?:[]) !== false) ? 'selected' : ''}}>{{ $language }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'Số điện thoại','field'=>[
                                            'label'=>'Số điện thoại','key'=>'phone', 'name' => 'phone', 'id' => 'phone', 'note' => '*', 'classNote' => 'text-danger',
                                            'attr' => [
                                                ['key' => 'maxlength', 'value' => '160'],
                                                ['key' => 'required', 'value' => 'required'],
                                                ['key' => 'partern', 'value' => "'#^(01([0-9]{2})|09[0-9]|08[0-9]|07[0-9]|05[0-9]|03[0-9])(\d{7})$#'"],
                                                ['key' => 'data-validation-required-message', 'value' => 'Số điện thoại không được để trống.'],
                                                ['key' => 'data-validation-regex-regex', 'value' => '^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$'],
                                                ['key' => 'data-validation-regex-message', 'value' => 'Số điện thoại không hợp lệ.'],
                                            ]
                                        ],
                                    ])
                                    @include('forms/input-group-text',[
                                        'placeholder'=>'Địa chỉ','field'=>[
                                            'label'=>'Địa chỉ', 'key'=>'address', 'name' => 'address', 'id' => 'address',
                                            'attr' => [
                                                ['key' => 'maxlength', 'value' => '160'],
                                            ]
                                        ],
                                    ])
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input type="text" class="form-control" placeholder="Website address">
                                    </div>
                                    <div class="form-group">
                                        <label>Favourite Music</label>
                                        <select class="form-control" name="musics[]" id="users-music-select2" data-toggle="select2" multiple="multiple">
                                            @php($musics = ['Rock', 'Jazz', 'Disco', 'Pop', 'Techno', 'Folk', 'Hip hop'])
                                            @foreach($musics as $music)
                                                <option value="{{ $music }}" {{ (array_search($music, json_decode(@$obj->musics)?:[]) !== false) ? 'selected' : ''}}>{{ $music }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Favourite movies</label>
                                        <select class="form-control" name="movies[]" id="users-movies-select2" data-toggle="select2" multiple="multiple">
                                            @php($movies = ['The Dark Knight', 'Harry Potter', 'Airplane', 'Perl Harbour', 'Spider Man', 'Iron Man', 'Avatar'])
                                            @foreach($movies as $movie)
                                                <option value="{{ $movie }}" {{ (array_search($movie, json_decode(@$obj->movies)?:[]) !== false) ? 'selected' : ''}}>{{ $movie }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Lưu thay đổi</button>
                                    <button type="reset" class="btn btn-light">Bỏ qua</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        @endif
                        <!-- users edit Info form ends -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- users edit ends -->
@push('JS_REGION')
    <script>
        window.addEventListener('load', function() {
            document.querySelector('#select-files').addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    var img = document.querySelector('#users-avatar');  // $('img')[0]
                    var file = this.files[0];
                    if(file.type === 'image/jpeg' || file.type === 'image/jpg' || file.type === 'image/png') {
                        if(file.size > 800000) {
                            return alert('Kích thước ảnh tối đa 800kB.')
                        }
                        img.src = URL.createObjectURL(file); // set src to blob url
                        /*img.forEach(function (e, i) {
                            e.src = URL.createObjectURL(file); // set src to blob url
                        })*/
                    }else {
                        return alert('Cho phép JPG, GIF hoặc PNG.')
                    }
                }
            });
            0 < $(".birthdate-picker").length && $(".birthdate-picker").pickadate({format: "mmmm d, yyyy"}),
            0 < $(".users-edit").length && $("input,select,textarea").not("[type=submit]").jqBootstrapValidation()
        });
        function revertItem(id = false, remove = true) {
            // remove: false => delete
            var title = "Bạn có chắc chắn muốn xóa bản ghi này?", confirmButtonText = "Vâng, Tôi muốn xóa!", titleDone = "Xóa Thành Công"
            if(remove) {
                title = "Bạn có chắc chắn muốn khôi phục bản ghi này?"
                titleDone = "Khôi Phục Thành Công"
                confirmButtonText = "Vâng, tôi muốn khôi phục"
            }
            Swal.fire({
                title: title,
                // text: "Lưu ý: dữ liệu bị xóa sẽ không thể phục hồi lại được!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonClass: "btn btn-success mt-2 btn-sm",
                cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                buttonsStyling: !1,
                confirmButtonText: confirmButtonText
            }).then(function (t) {
                if (t.value) {
                    shop.ajax_popup('user/delete', 'POST', {id: id, removed: remove}, function(json){
                        if(json.error == 0) {
                            Swal.fire({
                                title: titleDone,
                                type: "success",
                                showCancelButton: 0,
                                showConfirmButton: !0,
                                confirmButtonColor: "#3085d6",
                                confirmButtonClass: "btn btn-success mt-2 btn-sm",
                                buttonsStyling: !1,
                            });
                            shop.reload();
                        }else{
                            Swal.fire({
                                title: 'Oops!',
                                text: json.msg,
                                type: "warning",
                                showCancelButton: !0,
                                showConfirmButton: 0,
                                cancelButtonColor: "#d33",
                                cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                                buttonsStyling: !1,
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush