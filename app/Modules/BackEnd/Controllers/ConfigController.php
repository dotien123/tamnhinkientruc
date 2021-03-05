<?php

namespace App\Modules\BackEnd\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigSite as THIS;

class ConfigController extends BackendController
{
    public function __construct(){
        parent::__construct(new THIS());
        $this->bladeAdd = 'add';
        $this->registerAjax('route', 'ajaxUpdateRoute', 'change');
    }

    public function index(Request $request){
            return $this->returnView('index', [
            'site_title' => $this->title,
            'data' => $this->loadInfo()
        ]);
    }

    public function submit(Request $request){
        $valid = [
            [
                'site_name' => 'required|max:250',
                'email' => 'required|email',
                'version' => 'required',
            ]
        ];
        $this->validate($request, $valid[0], isset($valid[1]) ? $valid[1] : []);
        $default = $this->loadInfo();
        $default['image'] = $this->uploadImage($request, $request->site_name, 'image');
        $default['logo'] = $this->uploadImage($request, $request->site_name.'-logo', 'logo') ?? $default['logo'];
        $default['favicon'] = $this->uploadImage($request, $request->site_name.'-favicon', 'favicon') ?? $default['favicon'];
        $default['image_dev'] = $this->uploadImage($request, $request->site_name . 'dev', 'image_dev') ?? $default['image_dev'];
        $banner_contact = $this->uploadImage($request, $request->site_name . '-banner-contact', 'banner_contact');
        $default['banner_contact'] = !empty($banner_contact) ? $banner_contact : $default['banner_contact'];
        $logo_footer = $this->uploadImage($request, $request->site_name.'-logo-footer', 'logo_footer');
        $default['logo_footer'] = !empty($logo_footer) ? $logo_footer : $default['logo_footer'];

        foreach ($request->all() as $k => $v){
            if($k != '_token' && $k != 'image' && $k != 'image_dev' && $k != 'logo' && $k != 'favicon' && $k != 'banner_contact' && $k != 'logo_footer') {
                if (!empty($v)) {
                    $default[$k] = $v;
                } else {
                    $default[$k] = $v==0?$v:'';
                }
            }
        }
        THIS::setConfig($this->key, json_encode($default));
        return redirect()->route('admin.'.$this->key)->with('status', 'Đã cập nhật thành công');
    }

    protected function loadInfo(){
        $data = THIS::getConfig($this->key, '');
        return !empty($data) ? json_decode($data, true) : null;
    }

    protected function ajaxUpdateRoute(){
        $routes = \Lib::saveRoutes(false);
        return \Lib::ajaxRespond(true, 'ok', $routes);
    }
}
