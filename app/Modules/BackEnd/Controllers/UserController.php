<?php
namespace App\Modules\BackEnd\Controllers;

use App\Models\SysLog;
use Illuminate\Http\Request;

use App\Models\User as THIS;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class UserController extends BackendController
{
    protected $timeStamp = 'created';
    protected $titleField = 'user_name';

    public function __construct(){
        parent::__construct(new THIS(),[
            [
                'email' => 'required|email',
                'fullname' => 'required',
                'password' => 'required|min:6',
                'password_confirm' => 'same:password',
                'roles' => 'required',
            ],
            [
                'fullname.required' => 'Vui lòng nhập họ và tên của thành viên.',
                'roles.required' => 'Vui lòng phân quyền cho thành viên quản trị.',
                'email.email' => 'Email không hợp lệ. Vui lòng kiểm tra lại.',
                'password_confirm.same' => 'Mật khẩu xác nhận không khớp',
            ]
        ]);
        \View::share('roles', \Role::all()->sortBy('rank'));

        $this->registerAjax('change-password', 'ajaxChangePass');
        $this->registerAjax('see-more', 'ajaxSeeMore', 'view');
        $this->registerAjax('user-active', 'ajaxUserActive', 'edit');
        $this->registerAjax('delete', 'ajaxDelete', 'delete');
        $this->registerAjax('actived', 'ajaxActived');
        $this->registerAjax('customizer', 'ajaxCustomizer');
    }

    public function index(Request $request){
        $order = 'active DESC, last_active DESC, last_login DESC, id DESC';
        $cond = [['status','>','0']];
        $data = false;
        if($request->status != ''){
            switch($request->status){
                case -1:case 0:
                    $cond[0] = ['status','=',$request->status];
                    break;
                case 1:case 2:
                    $cond[] = ['active', $request->status == 1 ? '<=' : '>', 0];
                    break;
                case 3:
                    $cond[] = ['last_login','=',0];
                    break;
                case 4:case 5:
                    $timeOnline = time() - THIS::CheckOnlineTime;
                    if($request->status == 4){
                        $data = THIS::where('status', '>', 0)
                            ->where('active', '>', 0)
                            ->where('last_active', '>', 0)
                            ->where(function($q) use ($timeOnline){
                                $q->where('last_active', '<', $timeOnline)
                                    ->orWhere('last_logout', '>', 0);
                            });
                        $cond = [];
                    }else {
                        $cond[] = ['active', '>', 0];
                        $cond[] = ['last_active', '>=', $timeOnline];
                    }
                    $cond[] = ['last_active', $request->status == 5 ? '>=' : '<', $timeOnline];
                    break;
            }
        }
        if($request->user_name != ''){
            $cond[] = ['user_name','LIKE','%'.$request->user_name.'%'];
        }
        if($request->email != ''){
            $cond[] = ['email','LIKE','%'.$request->email.'%'];
        }
        if($request->phone != ''){
            $cond[] = ['phone','=',$request->phone];
        }
        
        if(!empty($request->time_from)){
            $timeStamp = \Lib::getTimestampFromVNDate($request->time_from);
            array_push($cond, ['created', '>=', $timeStamp]);
        }
        if(!empty($request->time_to)){
            $timeStamp = \Lib::getTimestampFromVNDate($request->time_to, true);
            array_push($cond, ['created', '<=', $timeStamp]);
        }
        if(!empty($cond)) {
            $data = $data === false ? THIS::where($cond) : $data->where($cond);

        }
        if($request->role != ''){
            $data->whereHas('roles', function($query) use ($request) {
                $query->where('id',$request->role);
            });

//            dd($allIds);
//            if(!empty($allIds)){
//                $data = $data->whereIn('id', array_keys($allIds));
//            }
        }
        $data = $data->orderByRaw($order)->paginate(25);
        return $this->returnView('index', [
            'lsObj' => $data,
            'search_data' => $request,
            'statusOpt' => THIS::getStatusOpt()
        ]);
    }

    public function log(Request $request, $uid){
        $user = THIS::find($uid);
        $cond = [];
        $order = 'created DESC';
        if($user) {
            $data = SysLog::where('env', 'admin')
                ->where('uid', $user->id);
            $time = explode(' - ', $request->time_between);
            if(is_array($time)) {
                foreach($time as $k => $t) {
                    $timeStamp = \Lib::getTimestampFromVNDate($t);
                    if (!$k) {
                        array_push($cond, ['created', '>=', $timeStamp]);
                    }else {
                        array_push($cond, ['created', '<=', $timeStamp]);
                    }
                }
            }
            if(!empty($cond)) {
                $data = $data->where($cond)->orderByRaw($order)->paginate($this->recperpage);
            }else{
                $data = $data->orderByRaw($order)->paginate($this->recperpage);
            }
            if($request->seeMore){
                $allSee = [];
                foreach ($data as $k => $d) {
                    $allSee[$k] = $d;
                    $allSee[$k]['created'] = \Lib::dateFormat(@$d['created'], 'H:i:s d/m/Y');
                    $allSee[$k]['action'] = @$d->getAction();
                }
                return \Lib::ajaxRespond(true, 'Lấy dữ liệu thành công', $allSee);
            }
            return $this->returnView('log', [
                'lsObj' => $data,
                'user' => $user,
                'search_data' => $request
            ]);

        }
        return $this->notfound();
    }

    public function showEditForm($uid){
        if($uid == \Auth::id()){
            if(session('status')){
                return redirect()->route('admin.'.$this->key.'.profile')->with('status', session('status'));
            }
            return redirect()->route('admin.'.$this->key.'.profile');
        }
        $obj = THIS::find($uid);
        set_old($obj);
        if($obj) {
            if(isset($obj->id) && @$obj->isRoot() || !\Auth::user()->biggerThanYou(@$obj->id)) {
                return view('BackEnd::403');
            }
            $title = 'Sửa thông tin người dùng '.@$obj->fullname;
            return $this->returnView('edit', [
                'site_title' => $title,
                'obj' => $obj,
                'preview' => request('preview'),
                'view' => request('view', 'full'),
                'user_roles' => UserRole::where('uid', $uid)->get()
            ],$title);
        }
        return $this->notfound();
    }

    public function showProfileForm(){
        $preview = request('preview');
        $type_view = request('view', 'full');
        $obj['preview'] = $preview;
        $obj['view'] = $type_view;
        $obj['site_title'] = 'Thông tin cá nhân';
        $obj['key'] = 'user';
        $obj['data'] = \Auth::user();
        \Lib::addBreadcrumb('Thông tin cá nhân');
        return $this->returnView('profile', $obj);
    }

    public function buildValidate(Request $request){
        $this->addValidate([
            'user_name' => 'min:4|max:60,unique:users,user_name,' . $this->editID,
            'email' => 'unique:users,email,' . $this->editID,
        ], [
            'user_name.unique' => 'Tên đăng nhập đã tồn tại. Vui lòng kiểm tra lại.',
            'email.unique' => 'Email đã tồn tại. Vui lòng kiểm tra lại.',
            'user_name.min' => 'Tên đăng nhập tối thiểu 4 ký tự.',
            'user_name.max' => 'Tên đăng nhập tối đa 60 ký tự.',
        ]);
        if ($request->hasFile('avatar')) {
            $this->addValidate(['avatar' => ['mimes:jpeg,jpg,png,gif,webp|max:8000','Ảnh đại diện']]);
        }
        if($this->editMode){
            if(empty($request->password)) {
                $this->ignoreValidate('password');
            }
            if($request->editProfile > 0){
                $this->ignoreValidate('roles');
            }
        }else{
            $this->addValidate(['user_name' => 'required|min:3|max:20|regex:#^[_a-zA-Z][0-9_a-zA-Z]*$#|unique:users,user_name']);
        }
    }

    function ajaxDelete(Request $request) {
        $id = $request->id?:0;
        if(!$id) {
            return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu!');
        }
        $obj = THIS::find($id);
        if($obj){
            $removed = ($request->removed == "true") ? THIS::REMOVED_NO : THIS::REMOVED_YES;
            $obj->update(['removed' => $removed]);
            if($request->removed != "true") {
                $this->delete($id);
            }else {
                $obj->update(['status' => THIS::STATUS_ACTIVE]);
            }
            return \Lib::ajaxRespond(true, 'Xóa dữ liệu thành công');
        }
        return \Lib::ajaxRespond(true, 'Xóa dữ liệu thành công');
    }

    public function beforeSave(Request $request, $ignore_ext = []){
        foreach ($request->all() as $val) {
            if(!is_array($val) && \Lib::is_profanity($val)){
                $this->setError(['is_profanity' => 'Nội dung nhạy cảm, từ ngữ thô tục. Vui lòng kiểm tra lại.']);
                return redirect()->back()->withInput()->withErrors($this->error);
            }
        }
        if(!$this->editMode){
            $this->model->created = time();
            $this->model->user_name = strtolower($request->user_name);
            $this->model->reg_ip = $request->ip();
            $this->model->active = 3;
            $this->model->status = 1;
        }
        if($request->user_name != '') {
            $this->model->user_name = $request->user_name;
        }
        if($request->password != '') {
            $this->model->password = bcrypt($request->password);
        }
        $this->model->fullname = $request->fullname;
        $this->model->email = $request->email;
        $this->uploadImage($request, $request->user_name, 'avatar');
    }

    public function afterSave(Request $request){
        //roles
        if(!empty($request->roles)){
            UserRole::where('uid', '=', $this->model->id)->delete();
            foreach($request->roles as $rid){
                $role = new UserRole;
                $role->uid = $this->model->id;
                $role->rid = $rid;
                $role->save();
            }
        }
    }

    public function beforeDelete($user)
    {
        if($user->id == \Auth::id()){
            $this->setError(['remove_yourself' => 'Bạn không thể tự xóa']);
        }elseif($user->isRoot() || !\Auth::user()->biggerThanYou($user->id)){
            $this->setError(['remove_root' => 'Bạn không có quyền thực hiện thao tác này']);
        }
    }

    function updateInfomation(Request $request) {
        $id = $request->id;
        $this->model = $this->model::find($id);
        if(empty($this->model)){
            return $this->notfound($id);
        }
        $before = $this->model;
        $all = $request->all();
        foreach ($all as $k => $val) {
            if(!is_array($val) && \Lib::is_profanity($val)){
                $this->setError(['google_plus' => 'Nội dung nhạy cảm, từ ngữ thô tục. Vui lòng kiểm tra lại.']);
                return redirect()->back()->withInput()->withErrors($this->error);
            }elseif (is_array($val)) {
                $all[$k] = json_encode($val);
            }
        }
        if($request->birthdate != '' && strtotime($request->birthdate) <= 0){
            $this->setError(['phone' => 'Ngày sinh không hợp lệ. Vui lòng kiểm tra lại.']);
            return redirect()->back()->withInput()->withErrors($this->error);
        }
        if(!\Lib::is_mobile($request->phone)){
            $this->setError(['phone' => 'Số điện thoại không hợp lệ.']);
            return redirect()->back()->withInput()->withErrors($this->error);
        }else {
            $this->validate($request, ['phone' => 'unique:users,phone,' . $id,], ['phone.unique' => 'Số điện thoại đã tồn tại. Vui lòng kiểm tra lại.']);
        }

        try{
            $data = $all;
            $ignore = array_merge(['_token', 'id'], []);
            foreach ($ignore as $i){
                unset($data[$i]);
            }
            foreach($data as $k => $v){
                $this->model->$k = $v;
            }
            $this->model->save();
            $this->editID = $this->model->id;
            $titleField = $this->titleField;
            \MyLog::do()->add($this->key.'-edit', $this->model->id, $this->model, $before);
            return redirect()->route('admin.'.$this->key.'.edit', $this->model->id)->with('status', $this->title.' <b>'.$this->model->$titleField.'</b> đã được cập nhật');
        }catch(\Exception $e){
            return redirect()->back()->withInput()->withErrors(['error:' => 'Có lỗi trong quá trình lưu dữ liệu! Vui lòng thử lại! '.$e->getMessage()]);
        }
    }

    protected function ajaxChangePass(Request $request){
        if (!(\Hash::check($request->old, \Auth::user()->password))) {
            return \Lib::ajaxRespond(false, 'Mật khẩu hiện tại không đúng', 1);
        }
        if(strcmp($request->old, $request->new) == 0){
            return \Lib::ajaxRespond(false, 'Mật khẩu mới phải khác mật khẩu cũ', 2);
        }
        //Change Password
        $user = \Auth::user();
        $user->password = bcrypt($request->new);
        $user->save();
        \MyLog::do()->add('info-pwd');
        return \Lib::ajaxRespond(true, 'Đổi mật khẩu thành công!!! Yêu cầu đăng nhập lại', ['url' => route('logout')]);
    }

    protected function ajaxUserActive(Request $request){
        if($request->id > 0) {
            $user = THIS::find($request->id);
            if ($user) {
                if(\Auth::user()->biggerThanYou($user->id)) {
                    \MyLog::do()->add('user-active', $user->id, $request->status, $user->active);
                    $user->active = $request->status;
                    $user->save();
                    if ($user->active == 0) {
                        THIS::forceLogout($user->id);
                    }
                    return \Lib::ajaxRespond(true, 'success');
                }
                return \Lib::ajaxRespond(false, 'Không có quyền thao tác');
            }
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }

    function ajaxCustomizer(Request $request) {
        if (\Auth::check()) {
            $uid = \Auth::user()->id;
            $exists = \DB::table('theme_customizer')->where('uid', $uid)->first();
            \DB::table('theme_customizer')->updateOrInsert(
                ['uid' => $uid],
                [
                    'uid' => $uid,
                    'icon_animation_switch' => $request->iconAnimationSwitch == 'true' ? 1 : 0,
                    'card_shadow_switch' => $request->cardShadowSwitch == 'true' ? 1 : 0,
                    'hide_scroll_top_switch' => $request->hideScrollTopSwitch == 'true' ? 1 : 0,
                    'collapse_sidebar_switch' => $request->collapseSidebarSwitch == 'true' ? 1 : 0,
                    'layout_options' => $request->layoutOptions?:'',
                    'navbar_colors' => $request->navbarColors,
                    'navbar_type' => $request->navbarType,
                    'footer_type' => ($request->footerType == 'footer-sticky') ? 'fixed-footer' : $request->footerType,
                ]
            );
            return \Lib::ajaxRespond(true, 'Thay đổi themes thành công!');
        }
    }

    protected function ajaxActived(Request $request){
        $user = \Auth::user();
        $user->last_active = time();
        $user->save();
        return \Lib::ajaxRespond(true, 'Actived');
    }
}
