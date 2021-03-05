@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
    <section id="card-actions">
            <div class="row mt-2">
                <div class="col-lg-12">
                    <div class="card-content collapse show">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url' => route('admin.config.post'), 'files' => true ]) !!}
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
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ (request('tab') != 'developers') ? 'active' : '' }}" data-toggle="tab" href="#website" role="tab" aria-controls="website" aria-expanded="true"><i class="icon-globe"></i> Website</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-expanded="false"><i class="icon-phone"></i> Liên hệ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-expanded="false"><i class="icon-star"></i> Mạng XH</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#configmail" role="tab" aria-controls="configmail" aria-expanded="false"><i class="icon-star"></i> Cấu hình Email</a>
                                </li>

{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link {{ (request('tab') == 'developers') ? 'active' : '' }}" data-toggle="tab" href="#developers" role="tab" aria-controls="developers" aria-expanded="false"><i class="fe-trending-up"></i> Về chúng tôi</a>--}}
{{--                                </li>--}}
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#route" role="tab" aria-controls="route" aria-expanded="false"><i class="icon-directions"></i> Định tuyến</a>
                                </li> --}}
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#security" role="tab" aria-controls="security" aria-expanded="false"><i class="icon-shield"></i> Bảo mật</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#other" role="tab" aria-controls="other" aria-expanded="false"><i class="icon-settings"></i> Khác</a>
                                </li>
                            </ul>

                            <div class="tab-content mb-4">
                                <div class="tab-pane {{ (request('tab') != 'developers') ? 'active' : '' }}" id="website" role="tabpanel" aria-expanded="true">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="pricing_board">Link danh sách bảng giá</label>
                                                <input type="text" class="form-control{{ $errors->has('pricing_board') ? ' is-invalid' : '' }}" id="pricing_board" name="pricing_board" value="{{ old('pricing_board', @$data['pricing_board']) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="recrui_link">Link Tuyển dụng</label>
                                                <input type="text" class="form-control{{ $errors->has('recrui_link') ? ' is-invalid' : '' }}" id="recrui_link" name="recrui_link" value="{{ old('recrui_link', @$data['recrui_link']) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="title">Tiêu đề website</label>
                                                <input type="text" class="form-control{{ $errors->has('site_name') ? ' is-invalid' : '' }}" id="site_name" name="site_name" value="{{ old('site_name', $data['site_name']) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="title">Từ khóa</label>
                                                <input type="text" class="form-control{{ $errors->has('keywords') ? ' is-invalid' : '' }}" id="keywords" name="keywords" value="{{ old('keywords', $data['keywords']) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="title">Mô tả website</label>
                                                <textarea rows="9" class="form-control{{ $errors->has('keywords') ? ' is-invalid' : '' }}" id="description" name="description">{{ old('description', $data['description']) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-9">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="title">List Icon</label>--}}
{{--                                                <textarea rows="9" class="form-control" id="list_font_awesome" name="list_font_awesome">{{ old('list_font_awesome', $data['list_font_awesome']) }}</textarea>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="title">Logo website <span class="text-warning">*</span></label>
                                                <input type="file" class="dropify" data-default-file="{{ !empty($data['logo_images']) ? $data['logo_images'] : '' }}" id="logo" name="logo">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="title">Favicon <span class="text-warning">*</span></label>
                                                <input type="file" class="dropify" data-default-file="{{ !empty($data['favicon_images']) ? $data['favicon_images'] : '' }}" id="favicon" name="favicon">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="title">Ảnh seo <small class="text-warning">Kích thước ảnh : 800x800px</small></label>
                                                <input type="file" class="dropify" data-default-file="{{ (!empty($data['image_medium_seo'])) ? $data['image_medium_seo'] : ''}}" id="image" name="image">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="title">Logo chân trang <span class="text-warning">*</span></label>
                                                <input type="file" class="dropify" data-default-file="{{ !empty($data['logo_footer_img']) ? $data['logo_footer_img'] : '' }}" id="logo_footer" name="logo_footer">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="contact" role="tabpanel" aria-expanded="false">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="title">Số điện thoại cố định: </label>
                                                        <input type="text" class="form-control{{ $errors->has('phone_contact') ? ' is-invalid' : '' }}" id="CSKH" name="phone_contact" value="{{ old('phone_contact', @$data['phone_contact']) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="title">Số điện thoại di động: </label>
                                                        <input type="text" class="form-control{{ $errors->has('phone_hcm') ? ' is-invalid' : '' }}" id="CSKH" name="phone_hcm" value="{{ old('phone_hcm', @$data['phone_hcm']) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="title">Email: </label>
                                                        <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email', @$data['email']) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="title">Website: </label>
                                                        <input type="text" class="form-control{{ $errors->has('email_hcm') ? ' is-invalid' : '' }}" id="email_hcm" name="email_hcm" value="{{ old('email_hcm', @$data['email_hcm']) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="title">Address Contact: </label>
                                                        <textarea class="form-control{{ $errors->has('address_contact') ? ' is-invalid' : '' }}" id="" name="address_contact" rows="3" placeholder="Please enter description">{{ old('address_contact', !empty($data['address_contact']) ? $data['address_contact'] : '') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="title">Address showroom: </label>
                                                        <input type="text" class="form-control{{ $errors->has('showroom') ? ' is-invalid' : '' }}" id="showroom" name="showroom" value="{{ old('showroom', @$data['showroom']) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="title">Vị trí (Map): </label>
                                                        <input type="text" class="form-control{{ $errors->has('map_contact') ? ' is-invalid' : '' }}" id="map_contact" name="map_contact" value="{{ old('map_contact', @$data['map_contact']) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="title">Mẫ số doanh nghiệp: </label>
                                                        <textarea class="form-control{{ $errors->has('code_company') ? ' is-invalid' : '' }}" id="" name="code_company" rows="5" placeholder="Please enter description">{{ old('code_company', !empty($data['code_company']) ? $data['code_company'] : '') }}</textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="social" role="tabpanel" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="facebook">Facebook</label>
                                                <input type="text" class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }}" id="facebook" name="facebook" value="{{ old('facebook', !empty($data['facebook']) ? $data['facebook'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="facebook_page">Facebook Page</label>
                                                <input type="text" class="form-control{{ $errors->has('facebook_page') ? ' is-invalid' : '' }}" id="facebook_page" name="facebook_page" value="{{ old('facebook_page', !empty($data['facebook_page']) ? $data['facebook_page'] : '') }}">
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="fb_app_id">Facebook App ID</label>
                                                <input type="text" class="form-control{{ $errors->has('fb_app_id') ? ' is-invalid' : '' }}" id="fb_app_id" name="fb_app_id" value="{{ old('fb_app_id', !empty($data['fb_app_id']) ? $data['fb_app_id'] : '') }}">
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{--<div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="fb_admins_id">Facebook Admins ID</label>
                                                <input type="text" class="form-control{{ $errors->has('fb_admins_id') ? ' is-invalid' : '' }}" id="fb_admins_id" name="fb_admins_id" value="{{ old('fb_admins_id', !empty($data['fb_admins_id']) ? $data['fb_admins_id'] : '') }}">
                                            </div>
                                        </div>
                                    </div>--}}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="skype">Skype</label>
                                                <input type="text" class="form-control{{ $errors->has('skype') ? ' is-invalid' : '' }}" id="skype" name="skype" value="{{ old('skype', !empty($data['skype']) ? $data['skype'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="zalo">Zalo</label>
                                                <input type="text" class="form-control{{ $errors->has('zalo') ? ' is-invalid' : '' }}" id="zalo" name="zalo" value="{{ old('zalo', !empty($data['zalo']) ? $data['zalo'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="messenger">Messenger</label>
                                                <input type="text" class="form-control{{ $errors->has('messenger') ? ' is-invalid' : '' }}" id="messenger" name="messenger" value="{{ old('messenger', !empty($data['messenger']) ? $data['messenger'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="chat">Chat</label>
                                                <input type="text" class="form-control{{ $errors->has('chat') ? ' is-invalid' : '' }}" id="chat" name="chat" value="{{ old('chat', !empty($data['chat']) ? $data['chat'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="app_id">APP ID</label>
                                                <input type="text" class="form-control{{ $errors->has('app_id') ? ' is-invalid' : '' }}" id="app_id" name="app_id" value="{{ old('app_id', !empty($data['app_id']) ? $data['app_id'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="facebook">Facebook account</label>
                                                <input type="text" class="form-control{{ $errors->has('facebook_name') ? ' is-invalid' : '' }}" id="facebook_name" name="facebook_name" value="{{ old('facebook_name', !empty($data['facebook_name']) ? $data['facebook_name'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="facebook">Group Facebook</label>
                                                <input type="text" class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }}" id="facebook" name="group_facebook" value="{{ old('group_facebook', !empty($data['group_facebook']) ? $data['group_facebook'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="facebook">Network</label>
                                                <input type="text" class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }}" id="network" name="network" value="{{ old('network', !empty($data['network']) ? $data['network'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="google">Google+</label>
                                                <input type="text" class="form-control{{ $errors->has('google') ? ' is-invalid' : '' }}" id="google" name="google" value="{{ old('google', !empty($data['google']) ? $data['google'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="google">Twitter</label>
                                                <input type="text" class="form-control{{ $errors->has('twitter') ? ' is-invalid' : '' }}" id="twitter" name="twitter" value="{{ old('twitter', !empty($data['twitter']) ? $data['twitter'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="instagram">Instagram</label>
                                                <input type="text" class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}" id="instagram" name="instagram" value="{{ old('instagram', !empty($data['instagram']) ? $data['instagram'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="zalo">Zalo+</label>
                                                <input type="text" class="form-control{{ $errors->has('zalo') ? ' is-invalid' : '' }}" id="zalo" name="zalo" value="{{ old('zalo', !empty($data['zalo']) ? $data['zalo'] : '') }}">
                                            </div>
                                        </div>
                                    </div>--}}
                                </div>

                                <div class="tab-pane" id="configmail" role="tabpanel" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="mail_driver">mail driver</label>
                                                <input type="text" class="form-control{{ $errors->has('mail_driver') ? ' is-invalid' : '' }}" id="mail_driver" name="mail_driver" value="{{ old('mail_driver', !empty($data['mail_driver']) ? $data['mail_driver'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="youtube">mail host</label>
                                                <input type="text" class="form-control{{ $errors->has('mail_host') ? ' is-invalid' : '' }}" id="mail_host" name="mail_host" value="{{ old('mail_host', !empty($data['mail_host']) ? $data['mail_host'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="zalo">mail port</label>
                                                <input type="text" class="form-control{{ $errors->has('mail_port') ? ' is-invalid' : '' }}" id="mail_port" name="mail_port" value="{{ old('mail_port', !empty($data['mail_port']) ? $data['mail_port'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="zalo">mail from address</label>
                                                <input type="text" class="form-control{{ $errors->has('mail_from_address') ? ' is-invalid' : '' }}" id="mail_from_address" name="mail_from_address" value="{{ old('mail_from_address', !empty($data['mail_from_address']) ? $data['mail_from_address'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="zalo">mail from name</label>
                                                <input type="text" class="form-control{{ $errors->has('mail_from_name') ? ' is-invalid' : '' }}" id="mail_from_name" name="mail_from_name" value="{{ old('mail_from_name', !empty($data['mail_from_name']) ? $data['mail_from_name'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="zalo">mail encryption</label>
                                                <input type="text" class="form-control{{ $errors->has('mail_encryption') ? ' is-invalid' : '' }}" id="mail_encryption" name="mail_encryption" value="{{ old('mail_encryption', !empty($data['mail_encryption']) ? $data['mail_encryption'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="zalo">mail username</label>
                                                <input type="text" class="form-control{{ $errors->has('mail_username') ? ' is-invalid' : '' }}" id="mail_username" name="mail_username" value="{{ old('mail_username', !empty($data['mail_username']) ? $data['mail_username'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="zalo">mail password</label>
                                                <input type="password" class="form-control{{ $errors->has('mail_password') ? ' is-invalid' : '' }}" id="mail_password" name="mail_password" value="{{ old('mail_password', !empty($data['mail_password']) ? $data['mail_password'] : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                
                                </div>


                                <div class="tab-pane" id="route" role="tabpanel" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="result"></div>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="shop.updateRoutes()"><i class="fe-send"></i> Cập nhật định tuyến</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="security" role="tabpanel" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="weakpass">Blacklist mật khẩu (cách nhau dấu ";")</label>
                                                <textarea rows="10" class="form-control{{ $errors->has('weakpass') ? ' is-invalid' : '' }}" id="weakpass" name="weakpass">{{ old('weakpass', !empty($data['weakpass']) ? $data['weakpass'] : '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="other" role="tabpanel" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="title">Lãi suất mua trả góp</label>
                                                <input type="text" class="form-control{{ $errors->has('interest') ? ' is-invalid' : '' }}" id="interest" name="interest" value="{{ old('interest', !empty($data['interest']) ? $data['interest'] : '') }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="title">Phiên bản JS/CSS</label>
                                                <input type="text" class="form-control{{ $errors->has('version') ? ' is-invalid' : '' }}" id="version" name="version" value="{{ old('version', $data['version']) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="checkbox-inline" for="mobile_active">
                                                <input type="checkbox" id="mobile_active" name="mobile_active" value="1" @if(old('mobile_active', isset($data['mobile_active']) ? $data['mobile_active'] : 0) == 1) checked @endif> Kích hoạt Mobile Wrap
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Mã nhúng đầu trang (trước < /head>)</label>
                                                <textarea type="text" class="seo form-control{{ $errors->has('script_head') ? ' is-invalid' : '' }}" rows="10" id="script_head" name="script_head">
                                            {{ old('script_head', !empty($data['script_head']) ? $data['script_head'] : '') }}
                                        </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Mã nhúng cuối trang (trước < /body>)</label>
                                                <textarea type="text" class="seo form-control{{ $errors->has('script_body') ? ' is-invalid' : '' }}" rows="10" id="script_body" name="script_body">
                                            {{ old('script_body', !empty($data['script_body']) ? $data['script_body'] : '') }}
                                        </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom-control">
                                <div class="container-fluid control-item">
                                    <button type="submit" class="btn btn-teal-800 waves-effect waves-light mr-3"><i class="fe-save"></i> Cập nhật</button>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
    
                    </div>
                    </div>
                    <!--- end row -->
                </div>
            </div>
@stop

@section('CSS_REGION')
    {!! \Lib::addMedia('admin/js/library/tag/jquery.tag-editor.css') !!}
    {!! \Lib::addMedia('admin/libs/summernote/summernote-bs4.css') !!}
    {!! \Lib::addMedia('admin/js/library/uploadifive/uploadifive.css') !!}
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/css/plugins/forms/validation/form-validation.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tags/jquery.tag-editor.css') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.css') !!}
@stop

@push('JS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.js') !!}
    {!! \Lib::addMedia('admin/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/js/scripts/navs/navs.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tinymce/jquery.tinymce.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tinymce/tinymce.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tags/jquery.caret.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tags/jquery.tag-editor.min.js') !!}
<script type="text/javascript">
    shop.updateRoutes = function () {
        shop.ajax_popup('route', 'POST', {}, function(json) {
            console.log(json);
            var html,i;
            html = '<div><b>PUBLIC ROUTES: </b></div>';
            for(i in json.data){
                html += '<p>'+json.data[i]+'</p>';
            }
            $('#result').html(html);
            shop.ajax_popup('config/route', 'POST', {}, function(json) {
                console.log(json);
                html = '<div><b>ADMIN ROUTES: </b></div>';
                for(i in json.data){
                    html += '<p>'+json.data[i]+'</p>';
                }
                $('#result').append(html);
            });
        },{
            baseUrl: ENV.PUBLIC_URL
        });
    };

    $(document).ready(function () {
        $('.dropify').dropify({
            messages: {
                'default': 'Kéo và thả tệp vào đây hoặc nhấp chuột tại đây.',
                'replace': 'Kéo và thả hoặc nhấp chuột để thay thế',
                'remove': 'Xóa',
                'error': 'Xin lỗi, có gì đó không đúng tại đây.'
            },
            error: {
                'fileSize': 'The file size is too big (1M max).'
            }
        });

        $("input.placement").maxlength(
            {
                alwaysShow: !0,
                placement: "top",
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });
        $('textarea#textarea').maxlength({
            alwaysShow: true,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        });
        tinymce.init({
            selector: 'textarea#content-description,textarea#content-description_f',
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            },

            plugins: 'print preview importcss searchreplace autolink save directionality visualblocks visualchars fullscreen image link media template code codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            mobile: {
                plugins: 'print preview importcss searchreplace autolink save directionality visualblocks visualchars fullscreen image link media template code codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons'
            },
            menubar: 'file edit view insert format tools table tc help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
            image_advtab: true,
            save_enablewhendirty: true,
            images_upload_base_path: '/admin/ajax/file/upload-file',
            images_upload_credentials: true,
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '/admin/ajax/file/upload-file');
                xhr.setRequestHeader("X-CSRF-Token", jQuery('meta[name=_token]').attr("content"));
                xhr.onload = function() {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.data.full_size_link != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.data.full_size_link);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
            branding: false,
            link_list: [
                { title: 'My page 1', value: 'http://www.tinymce.com' },
                { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_list: [
                { title: 'My page 1', value: 'http://www.tinymce.com' },
                { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Some class', value: 'class-name' }
            ],
            importcss_append: true,
            height: 400,
            templates: [
                { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
                { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
                { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
            ],
            template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_mode: 'sliding',
            spellchecker_dialog: true,
            spellchecker_whitelist: ['Ephox', 'Moxiecode'],
            content_style: ".mymention{ color: gray; }",
            contextmenu: "link image imagetools table configurepermanentpen",
            a11y_advanced_options: true,
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px"
        });
    });
</script>
    {!! \Lib::addMedia('admin/js/form-fileuploads.init.js') !!}
@endpush