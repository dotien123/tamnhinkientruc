<?php

namespace App\Modules\BackEnd\Controllers;

use App\Libs\BizPay;
use App\Libs\LoadDynamicRouter;
use App\Libs\WePayAPI;
use App\Models\Customer;
use App\Models\DetailInfoProduct;
use App\Models\Bank;
use App\Models\GeoDistrict;
use App\Models\OrderItems;
use App\Models\OrderLog;
use DB;
use Validator;
use App\Models\GeoProvince;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Order as THIS;

class OrderController extends BackendController
{
    //config controller, ez for copying and paste
    protected $timeStamp = 'created';
    protected $titleField = 'code';
    protected $foods_perpage = 5;

    public function __construct() {
        parent::__construct(new THIS(), []);
        $this->registerAjax('save', 'ajaxUpdateOrder', 'edit');
        $this->registerAjax('delete', 'ajaxDeleteOrder', 'delete');
        $this->registerAjax('cancelle', 'ajaxCancelleOrder', 'delete');
        $this->registerAjax('popup-preview', 'ajaxPreviewOrder', 'view');
    }

    public function index(Request $request)
    {
        $tpl = [];
        $order = 'created DESC, id DESC';
        $cond = [];
        $status = Request::capture()->input('status', '');
        if($status != ''){
            if($status == 'no-paid') {
                $status = THIS::STATUS_NO_PAID;
            }else if($status == 'pending') {
                $status = THIS::STATUS_PENDING;
            }else if($status == 'ready-ship') {
                $status = THIS::STATUS_READY_SHIP;
            }else if($status == 'shiped') {
                $status = THIS::STATUS_SHIPED;
            }else if($status == 'delivered') {
                $status = THIS::STATUS_DELIVERED;
            }else if($status == 'cancelled') {
                $status = THIS::STATUS_CANCELLED;
            }else if($status == 'returned') {
                $status = THIS::STATUS_RETURNED;
            }else if($status == 'fail-delivery') {
                $status = THIS::STATUS_FAIL_DELIVERY;
            }else if($status == 'deleted') {
                $status = THIS::STATUS_DELETED;
            }else {
                $status = '';
            }
            $cond[] = ['status','=', $status];
        }
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
        if($request->code != ''){
            $cond[] = ['code','LIKE','%'.$request->code.'%'];
        }
        $select = ['code', 'id', 'full_name', 'telephone', 'email', 'street', 'note', 'created', 'payment_type', 'bank_id', 'status', 'total', 'number', 'grandTotal'];
        $listObj = THIS::where($cond)->select($select)->orderByRaw($order)->paginate(10);
        $tpl['lsStatus'] = THIS::getListStatus();
        $tpl['lsObj'] = $listObj;
        $tpl['search_data'] = $request;

        return $this->returnView('index', $tpl);
    }

    public function log(Request $request, $id)
    {
        $cond = [];
        $order = 'created DESC, id DESC';
        $order = THIS::find($id);
        if ($order) {
            $data = OrderLog::where('order_id', $id);

            $time = explode(' - ', $request->time_between);
            if(is_array($time) && count($time) > 1) {
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
                $data = $data->where($cond)->orderBy('id', 'DESC')->paginate($this->recperpage);
            }else{
                $data = $data->orderBy('id', 'DESC')->paginate($this->recperpage);
            }
            $title = 'Xem lịch sử đơn hàng';
            return $this->returnView('log', [
                'site_title'  => $title,
                'order'       => $order,
                'lsObj'        => $data,
                'search_data' => $request
            ], $title);
        }
        return $this->notfound();
    }

    public function ajaxUpdateOrder(Request $request) {
        $obj = THIS::find($request->order_id);
        if($obj) {
            // $obj->items->

            $obj->update(['status' => $request->id]);
            //Save log order
            OrderLog::add($obj->id, $request->id, 'Thành công');

            // sendmail nếu hàng sang trạng thái sẵn sàng giao
            // trừ số lượng hàng nếu hàng đã thanh toán
            if($request->id == THIS::STATUS_DELIVERED) {
                foreach($obj->items as $item) {
                    $detailPro = DetailInfoProduct::find($item->product_id);
                    if($detailPro) {
                        $quantity = (int)$detailPro->quantity - (int)$item->quantity;
                        $detailPro->update(['quantity' => $quantity]);
                    }
                }
            }
            return \Lib::ajaxRespond(true, 'success', $obj);
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }

    public function ajaxDeleteOrder(Request $request) {
        $ids = $request->ids;
        if(isset($ids) && !empty($ids) && \is_array($ids)) {
            $lsObj = THIS::whereIN('id', $ids)->update(['status' => THIS::STATUS_DELETED]);
            //Save log order
            foreach($ids as $id) {
                OrderLog::add($id, THIS::STATUS_DELETED, 'Thành công');
            }
            return \Lib::ajaxRespond(true, 'success', $lsObj);
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }

    public function ajaxCancelleOrder(Request $request) {
        $ids = $request->ids;
        if(isset($ids) && !empty($ids) && \is_array($ids)) {
            $lsObj = THIS::whereIN('id', $ids)->update(['status' => THIS::STATUS_CANCELLED]);
            return \Lib::ajaxRespond(true, 'success', $lsObj);
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }

    public function ajaxPreviewOrder(Request $request) {
        $obj = THIS::find($request->id);

        if($obj) {
            $tpl = [];
            if(THIS::paymentType(FALSE, $obj->payment_type) == __('site.chuyenkhoanATM')) {
                $tpl['bank'] = Bank::find($obj->bank_id);
            }
            $tpl['lsObj'] = $obj->items;
            $tpl['obj'] = $obj;
            $data = \View::make("BackEnd::pages.order.include.popup.preview", $tpl)->render();
            echo $data;die;
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }
    public function ajaxPreviewLogOrder(Request $request) {
        $lsObj = OrderLog::where('order_id', $request->id)->get();

        if($lsObj) {
            $tpl = [];
            if(THIS::paymentType(FALSE, $obj->payment_type) == __('site.chuyenkhoanATM')) {
                $tpl['bank'] = Bank::find($obj->bank_id);
            }
            $tpl['lsObj'] = $obj->items;
            $tpl['obj'] = $obj;
            $data = \View::make("BackEnd::pages.order.include.popup.preview", $tpl)->render();
            echo $data;die;
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }
}