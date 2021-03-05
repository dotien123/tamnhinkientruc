<?php

namespace App\Modules\BackEnd\Controllers;

use App\Models\Customer;
use App\Models\Story as THIS;
use Illuminate\Support\Facades\Auth;

class StoryController extends BackendController
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
        $this->registerAjax('add-royalty-payment', 'ajaxPostRoyaltyPayment');
    }

    public function index(Request $request){
        $data = THIS::getAllNewsByCustomer($this->recperpage);
//        dd($data);
        if (!empty($request->email)) {
            $data = $data->where('email', $request->email);
        }
        if($request->fullname != ''){
            $data = $data->where('fullname',$request->fullname);
        }
        if (!empty($request->phone)) {
            $data = $data->where('phone', $request->phone);
        }
        return $this->returnView('index', [
            'data' => $data,
            'search_data' => $request
        ]);
    }

    public function log(Request $request, $id)
    {
        $logs = RoyaltyPaymentLog::getAllLogByIDNews($id, 8);
        if ($logs) {
            if (!empty($request->time_from)) {
                $timeStamp = \Lib::getTimestampFromVNDate($request->time_from);
                $logs = $logs->where('created', '>=', $timeStamp);
            }
            if (!empty($request->time_to)) {
                $timeStamp = \Lib::getTimestampFromVNDate($request->time_to, true);
                $logs = $logs->where('created', '<=', $timeStamp);
            }
            $title = 'Xem log trả nhuận bút';
            return $this->returnView('logs', [
                'site_title'  => $title,
                'logs'       => $logs,
                'id'       => $id,
                'search_data' => $request
            ], $title);
        }
        return $this->notfound();
    }

    public function ajaxPostRoyaltyPayment(Request $request) {
        if($request->id > 0) {
            $data = THIS::where([['new_id', $request->id], ['type', $request->type]])->first();
            $customer = Customer::where('id', $data->user_id)->first();
//            dd(RoyaltyPaymentLog::getNewsLogsById($customer->id), $customer->id);
            if ($data && $customer) {
                $data->royalty_payment = ($request->royalty) ? $request->royalty : null;
                $data->save();
                $money_log = RoyaltyPaymentLog::getNewsLogsById($customer->id, $request->id);
                if($money_log) {
                    $customer->money = $data->royalty_payment + $customer->money - $money_log;
                }else {
                    $customer->money = $data->royalty_payment + $customer->money;
                }
                $customer->save();
                $log = new RoyaltyPaymentLog();
                $log->user_id = $data->user_id;
                $log->new_id = $request->id;
                $log->admin_id = \Auth::id();
                $log->created = time();
                $log->money = $data->royalty_payment;
                $log->save();

                return \Lib::ajaxRespond(true, 'success');
            }
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
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

    }

    public function afterSave(Request $request){

    }
}
