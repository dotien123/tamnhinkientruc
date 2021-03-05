<?php

namespace App\Modules\BackEnd\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function __construct(){}

    public function init(Request $request, $cmd){
        $data = [];
        $perm = true;
        switch ($cmd) {
            case 'notify':
                $data = $this->notify($request);
                break;
            default:
                $data = $this->nothing();
        }
        if(!$perm) {
            $data = \Lib::ajaxRespond(false, 'Access denied');
        }
        return response()->json($data);
    }

    /*public function actived(Request $request){
        $user = \Auth::user();
        $user->last_active = time();
        $user->save();
        return \Lib::ajaxRespond(true, 'Actived');
    }*/

    public function nothing(){
        return "Nothing...";
    }

    public function notify(Request $request){
        $data = [
            'notify' => 0,
            'order' => 0,
            'table' => 0
        ];
        /*try {
            $res = Booking::where('user_id', 0)->where('status', 1)->get();
            $data['notify'] = $res->count();
            $data['order'] = $res->where('type', 'order')->count();
            $data['table'] = $res->where('type', 'table')->count();
        }catch (\Exception $e){
            return \Lib::ajaxRespond(true, 'ok', $data);
        }*/
        return \Lib::ajaxRespond(true, 'ok', $data);
    }
}
