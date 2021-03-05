<?php

namespace App\Modules\BackEnd\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\Customer as THIS;

class CustomerController extends BackendController
{
    //
    public function __construct(){
        $this->bladeAdd = 'add';
        parent::__construct(new THIS(),[
            [
                'email' => 'required|email',
                'fullname' => 'required',
                'password' => 'required|min:6',
                'password_confirm' => 'required|same:password'
            ]
        ]);
    }

    public function index(Request $request){
        $order = 'created DESC, id DESC';
        $cond = [['status','>','0']];
        if($request->phone != ''){
            $cond[] = ['phone','LIKE','%'.$request->phone.'%'];
        }
        if($request->email != ''){
            $cond[] = ['email','LIKE','%'.$request->email.'%'];
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
            $data = THIS::where($cond)->orderByRaw($order)->paginate($this->recperpage);
        }else{
            $data = THIS::orderByRaw($order)->paginate($this->recperpage);
        }
        return $this->returnView('index', [
            'data' => $data,
            'search_data' => $request
        ]);
    }

    public function buildValidate(Request $request){
        $this->addValidate(['email' => 'unique:customers,email,' . $this->editID]);
        if(!empty($request->phone)){
            $this->addValidate(['phone' => 'numeric|unique:customers,phone,' . $this->editID]);
        }
        if($this->editMode && empty($request->password)){
            $this->ignoreValidate(['password', 'password_confirm']);
        }
    }

    public function beforeSave(Request $request, $ignore_ext = []){
        if(!$this->editMode){
            $this->model->created = time();
            $this->model->user_name = strtolower($request->email);
            $this->model->reg_ip = $request->ip();
            $this->model->active = 1;
            $this->model->status = 1;
        }
        $this->model->fullname = $request->fullname;
        $this->model->email = strtolower($request->email);
        $this->model->phone = $request->phone;
        if($request->password != '') {
            $this->model->password = bcrypt($request->password);
        }
    }

    public function afterSave(Request $request){
        $subscriber = Subscriber::where('email', $this->model->email)->first();
        if (empty($subscriber)) {
            $subscriber = new Subscriber();
            $subscriber->email = $this->model->email;
            $subscriber->created = time();
        }
        $subscriber->customer_id = $this->editID;
        $subscriber->save();
    }
}
