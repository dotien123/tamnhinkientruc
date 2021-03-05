<?php

namespace App\Modules\BackEnd\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Order;
use App\Models\Subscriber;
use App\Models\SubscriberContribute;
use Carbon\Carbon;

class HomeController extends Controller
{
    //
    public function __construct(){
        \Lib::addBreadcrumb();
    }

    public function index(){
        $tpl = []; $totalRevenue = 0;
        $order = 'created DESC, id DESC';
        $tpl['site_title'] = ' Trang chủ';
        $cond = [];
        $time = explode(' - ', \request('time_between'));
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
        $todayOrder = Order::select('id', 'created', 'status', 'grandTotal')->get()->groupBy(function($date) {
            // dd($date);
            $dateInt=date("Y-m-d", $date->created);
            return Carbon::parse($dateInt)->format('d-m-Y');
        });
        if(!empty(request('time_from'))){
            $datetime = request('time_from');
            if(isset($todayOrder[$datetime])) {
                $tpl['todayOrder'] = count($todayOrder[$datetime]);
                foreach($todayOrder[$datetime] as $item) {
                    $totalRevenue += $item->grandTotal;
                }
            }
            $tpl['lsOrderNopaid'] = Order::where('status', Order::STATUS_NO_PAID)->where($cond)->orderByRaw($order)->limit(5)->get();
            $tpl['lsProductNew'] = Product::where('status', BaseModel::STATUS_ACTIVE)->where('created', '>=', \Lib::getTimestampFromVNDate($datetime))->orderByRaw($order)->limit(5)->get();
        }else {
            if(isset($todayOrder[date('d-m-Y')])) {
                $tpl['todayOrder'] = count($todayOrder[date('d-m-Y')]);
                foreach($todayOrder[date('d-m-Y')] as $item) {
                    $totalRevenue += $item->grandTotal;
                }
            }

            $tpl['lsOrderNopaid'] = Order::where('status', Order::STATUS_NO_PAID)->where($cond)->orderByRaw($order)->limit(5)->get();
            $tpl['lsProductNew'] = Product::where('status', BaseModel::STATUS_ACTIVE)->orderByRaw($order)->limit(5)->get();
        }
        $tpl['san_pham_yeu_thich'] = OrderItems::getIdsProductYeuThich();
        $tpl['todayTotalRevenue'] = \Lib::priceFormat($totalRevenue, ',' ,' VNĐ');

        $tpl['search_data'] = \request();
        $tpl['totalProduct'] = Product::where('status', BaseModel::STATUS_ACTIVE)->count();
        return view('BackEnd::pages.home.index', $tpl);
    }

    public function checkAuth(){
        return redirect()->to(url()->full().'/login')->send();
    }

   
}
