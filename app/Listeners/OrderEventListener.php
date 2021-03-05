<?php

namespace App\Listeners;

use App\Libs\FunctionLib;
use App\Libs\LoadDynamicRouter;
use App\Libs\OlalaMail;
use App\Mail\OrderSuccessCustomer;
use App\Mail\OrderSuccessAdmin;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderRefund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class OrderEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(Event $event)
    {
        //
    }

    public function onSendMailSuccess($id = 0, $order = []) {
        if(empty($order) && $id > 0) {
            $order = Order::find($id);
        }
        if(!empty($order)) {
            $title = '['.env('APP_NAME').'] Thông tin đặt hàng thành công - #'.$order->code;

            //send email active
            if(\Lib::is_valid_email($order->email)) {
                // $r = OlalaMail::send('', $order->email, $title, ['emails.order.success', ['order' => $order,'payment_types' => Order::paymentType()]]);
                $r = Mail::to($order->email)->send(new OrderSuccessCustomer($order, $order->payment_type));
                //thong bao admin
                $this->onOrderAdminNotice($order);

                //Save log order
                OrderLog::add($order->id, 'email_buy', !empty($r) ? 'Thành công' : 'Thất bại');
            }
        }
    }

    public function onOrderAdminNotice($order)
    {
        LoadDynamicRouter::loadRoutesFrom('BackEnd');
        $config = FunctionLib::getSiteConfig();
        if (isset($config['email_order'])){
            $mails = explode(",",$config['email_order']);
            $mail = new OrderSuccessAdmin($order,Order::paymentType());
            $mail->to($mails);
            OlalaMail::sendMailable($mail);
        }
    }

    public function onRefund($id, $order,$request,$status){
        if(empty($order)) {
            $order = Order::find($id);
        }
        if($order) {
            switch ($status){
                case 5:
                    $order->update(['updated' => time(),'status' => 5,'user_id'=>\Auth::id()]);
                    /*add to refund table*/
                    $refund = new OrderRefund();
                    $refund->created = time();
                    $refund->refund_fee = $request[''];
                    $refund->user_id = \Auth::id();
                    $refund->reason = $request->reason;
                    $order->order_refund()->save($refund);

                    \MyLog::do()->add(Order::KEY . '-request-refund', $order->id);
                    OrderLog::add($order->id,'request_refund',$request->reason);
                    break;
                case 6:
                    $order->update(['updated' => time(),'status' => 6]);
                    /*Accept refund*/
                    $order->order_refund()->update([
                        'process_user'=>\Auth::id(),
                        'process_time'=>time(),
                        'status'=>1,
                        'note'=>$request->note
                    ]);

                    \MyLog::do()->add(Order::KEY . '-confirm-refund', $order->id);
                    OrderLog::add($order->id,'confirm_refund',$request->note);
                    break;
                case 7:
                    $order->update(['updated' => time(),'status' => 7]);
                    /*Accept refund*/
                    $order->order_refund()->update([
                        'process_user'=>\Auth::id(),
                        'process_time'=>time(),
                        'status'=>2,
                    ]);
                    \MyLog::do()->add(Order::KEY . '-done-refund', $order->id);
                    OrderLog::add($order->id,'done_refund');
                    break;
            }
        }
    }

    public function onDelete($id, $order,$request){
        if(empty($order)) {
            $order = Order::find($id);
        }
        if($order) {
            $order->update(['updated' => time(), 'status' => 6]);

            $order->order_refund()->update([
                'process_user' => \Auth::id(),
                'process_time' => time(),
                'status' => -1,
                'note' => $request->note
            ]);
//            \Olala::send('', $order->email, $title, ['email.order.success', ['order' => $order]]);
            //Save log order
            \MyLog::do()->add(Order::KEY . '-remove', $order->id);
            OrderLog::add($order->id, 'delete', $request->reason);
        }
    }



    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'order.success',
            'App\Listeners\OrderEventListener@onSendMailSuccess'
        );
        $events->listen(
            'order.refund',
            'App\Listeners\OrderEventListener@onRefund'
        );
        $events->listen(
            'order.delete',
            'App\Listeners\OrderEventListener@onDelete'
        );
    }

}