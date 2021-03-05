<?php

namespace App\Listeners;

use App\Mail\CustomerRegister;
use App\Mail\CheckMailsubmit;
use App\Mail\CustomerResetPassword;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class CustomerEventListener
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

    public function customeRequestSendMail($data = []) {
        try {
            $config_from_db = DB::table('__configs')->where('key', 'config')->first();
            $config_from_db = !empty($config_from_db->value) ? json_decode($config_from_db->value, true) : null;

            $address = @$config_from_db['mail_from_address'] ?? 'abc@abc.com';
            $name = @$config_from_db['mail_from_name'] ?? 'abc@abc.com';

            Mail::send('emails.mailSale.mailSend', array(
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'content' => $data['content'],
            ), function($message) use ($address, $name) {
                $message->to($address, $name)->subject($name);
            });
        }catch(\Exception $e) {

        }

    }

    public function RequestMailSale($data = []) {
        try {
            $config_from_db = DB::table('__configs')->where('key', 'config')->first();
            $config_from_db = !empty($config_from_db->value) ? json_decode($config_from_db->value, true) : null;
            $address = @$config_from_db['mail_from_address'] ?? 'abc@abc.com';
            $name = @$config_from_db['mail_from_name'] ?? 'abc@abc.com';

            $tra_hang_thang = str_replace('.','', $data['tra_hang_thang']);
            $emails = [$address, $data['email'] ];
            Mail::send('emails.mailSale.mailSucces', array(
                'tra_hang_thang' => $tra_hang_thang,
                'laisuat' => $data['laisuat'],
                'giaxe' => $data['giaxe'],
                'tratruoc' => $data['tratruoc'],
                'titleProduct' => $data['titleProduct'] ? $data['titleProduct'] : '',
                'thoihanvay' => $data['thoihanvay'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'name' => $data['name'],
            ), function($message) use ($emails, $name)
            {    
                $message->to($emails)->subject($name);    
            });
        }catch(\Exception $e) {
            
        }
        
    }
  
    public function onCustomerLogin(Login $event) {
        $user = $event->user;
        if(is_a ( $user , 'App\Models\Customer' )) {
            if ($user->active > 0 && $user->status == 1) {
                $user->last_login = time();
                $user->last_login_ip = $this->request->ip();
                $user->save();
            } else {
                \Auth::guard('customer')->logout();
            }
        }
    }


    public function onCustomerRegister($id) {
        $customer = Customer::find($id);
        if($customer) {
            \Mail::to($customer->email)->send(new CustomerRegister($customer));
        }
    }

    public function onCustomerRequestPassword($id) {
        $customer = Customer::find($id);
        if($customer){
            \Mail::to($customer->email)->send(new CustomerResetPassword($customer));
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
            'customer.register',
            'App\Listeners\CustomerEventListener@onCustomerRegister'
        );

        $events->listen(
            'customer.register.resend',
            'App\Listeners\CustomerEventListener@onCustomerRegister'
        );

        $events->listen(
            'customer.password',
            'App\Listeners\CustomerEventListener@onCustomerRequestPassword'
        );

        
        $events->listen(
            'customer.sendmail',
            'App\Listeners\CustomerEventListener@customeRequestSendMail'
        );

        $events->listen(
            'customer.RequestMailSale',
            'App\Listeners\CustomerEventListener@RequestMailSale'
        );

    }

}