<?php

namespace App\Modules\FrontEnd\Controllers;

use App\Jobs\ProcessQueueCoupon;
use App\Libs\CRMLib;
use App\Libs\OlalaMail;
use App\Libs\CouponLib;
use App\Models\CouponArchive;
use App\Models\Customer;
use App\Models\DetailInfoProduct;
use App\Models\GeoDistrict;
use App\Models\GeoWard;
use App\Models\GcmEndpoint;
use App\Models\Quiz;
use App\Models\SubscriberContribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Cart;
use App\Models\Store;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Helpers\GGCapcha;

//custom models
use App\Models\Subscriber;
use App\Models\Purchase;
use Illuminate\Support\Facades\Redis;


class AjaxController extends Controller
{
    public function __construct()
    {
        //
    }
    public function init(Request $request, $cmd){
        $data = [];
        switch ($cmd) {
            case 'seemore':
                $data = $this->loadSeemore($request);
            break;
            case 'login':
                $data = $this->login($request);
                break;
            case 'register':
                $data = $this->register($request);
                break;
            case 'email-active':
                $data = $this->emailActive($request);
                break;
            case 'checkComment':
                $data = $this->checkComment($request);
                break;
            case 'subscribe':
                $data = $this->subscribe($request);
                break;
            case 'subscribeSale':
                $data = $this->subscribeSale($request);
                break;
            case 'subscribe-contribute':
                $data = $this->subscribeContribute($request);
                break;
            case 'route':
                $data = $this->updateRoute($request);
                break;
            case 'cart-load':
                $data = $this->cartShow($request);
                break;
            case 'cart-add':
                $data = $this->cartAdd($request);
                break;
            case 'cart-update':
                $data = $this->cartUpdate($request);
                break;
            case 'cart-remove':
                $data = $this->cartRemove($request);
                break;
            case 'cart-change-package':
                $data = $this->cartChangePackage($request);
                break;
            case 'check-coupon':
                $data = $this->checkCoupon($request);
                break;
            case 'list-districts':
                $data = $this->listDistricts($request);
                break;
            case  'list-ward' :
                $data = $this->listWards($request);
                break;
            case 'get-local':
                $data = $this->ajaxGetAddress($request);
                break;
            case 'get-map':
                $data = $this->ajaxGetMap($request);
                break;
            case 'change-profile':
                $data = $this->ajaxChangeProfile($request);
                break;
            default:
                $data = $this->nothing();
        }
        return response()->json($data);
    }

    public function loadSeemore(Request $request)
    {
        $data = Comment::where([['tableName', $request->table], ['comment_parent', $request->id_comment], ['status', 1] ])->distinct()->get();

        if(count($data) > 2)
        {
            $html = view('ajaxReponse.comment')->with(compact('data'))->render();
        }
        else
        {
            $html = '';
        }
        return response()->json(['success' => true, 'html' => $html]);

    }

    public function ajaxChangeProfile(Request $request){
        $form = $request->form;
        $result = [];
        foreach ($form as $item){
            $result[$item['name']] = $item['value'];
        }
        $validate = \Validator::make(
            $result,
            [
                'email' => 'required|email',
                'fullname' => 'required',
            ],
            [
                'email.required' => 'Chưa nhập Email',
                'email.email' => 'Email không hợp lệ',
                'fullname.required' => 'Chưa nhập đầy đủ họ tên'
            ]
        );
        if ($validate->fails()) {
            return \Lib::ajaxRespond(false, 'error', $validate->errors()->all());
        }
        //user hien tai dang login
        $user = \Auth::guard('customer')->user();
        if(empty($user)){
            return \Lib::ajaxRespond(false, 'error', 'Bạn không có quyên thay đôi !!!');
        }
        // check Email da ton tai trong he thong
        $customer = Customer::where('email', $result['email'])->first();
        if(isset($customer) && ($user->email !== $customer->email )){
            return \Lib::ajaxRespond(false, 'error', ['Email đã tồn tại trong hệ thống']);
        }

        // cap nhat
        $user = Customer::changeProfile($user , $result );

        if($user){
            return \Lib::ajaxRespond(true,  __('site.capnhatthanhcong'));
        }
        return \Lib::ajaxRespond(false, 'error', 'Lỗi hệ thống');
    }

    public function ajaxGetAddress(Request $request){
        if($request->keySearch){
            $storeName = $request->keySearch;
            $data = Store::where('status', '>' , 1)->where('store_name' , 'LIKE' , '%'.$storeName.'%')
                ->get();
            if(!empty($data)){
                return \Lib::ajaxRespond(true, 'success' , $data);
            }
            return \Lib::ajaxRespond(false, 'Không có dữ liệu');
        }
        return \Lib::ajaxRespond(false, 'Không có dữ liệu');
    }

    public function ajaxGetMap(Request $request){
        $order = [];
        if($request->keySearch != ''){
            $order[] = ['store_name' , 'LIKE' , '%'.$request->keySearch.'%'];
        }else{
            return \Lib::ajaxRespond(false, 'Không có dữ liệu');
        }
//        dd($order);
        // lat-long
//        $data = Store::getLatLng($order);
        $data = Store::getMap($order);
        if(!empty($data)){
            return \Lib::ajaxRespond(true, 'success' , $data);
        }
        return \Lib::ajaxRespond(false, 'Không có dữ liệu');
    }


    public function listWards($request) {
        $district_id = $request->get('district_id');
        $data = GeoWard::getListwards($district_id);
//        dd($data->toArray());
        if(!empty($data)) {
            return \Lib::ajaxRespond(true, 'success', $data);
        }
    }

    public function listDistricts($request) {
        $province_id = $request->get('province_id');
        $data = GeoDistrict::getListDistrictsByCity($province_id);
        if(!empty($data)) {
            return \Lib::ajaxRespond(true, 'success', $data);
        }
    }

    public function cartShow(Request $request){
        $content = Cart::getInstance()->content();
        return \Lib::ajaxRespond(true, 'success', $this->cartMixConent($content));
    }

    public function cartRemove(Request $request){
        Cart::getInstance()->remove($request->id);
        $content = Cart::getInstance()->content();
        return \Lib::ajaxRespond(true, 'success', $this->cartMixConent($content));
    }

    public function cartChangePackage(Request $request){
        Cart::getInstance()->remove($request->old_id);
        $return = $this->cartAdd($request,false,true);
        $content = Cart::getInstance()->content();
        return \Lib::ajaxRespond(true, 'success', $this->cartMixConent($content));
    }

    public function cartUpdate(Request $request){
        return $this->cartAdd($request, true);
    }

    public function cartAdd(Request $request, $replace = false,$call_only = false){
        if($replace) {
            $item = Cart::getInstance()->get($request->index);
            $detailObj = DetailInfoProduct::find(@$item['id']);
        }else {
            $detailObj = DetailInfoProduct::find($request->id);
        }

        $quan = $request->quan?:1;
        $filter_ids = $request->filter_ids?:[];
        if($detailObj){
            if($detailObj->quantity == 0) {
                return \Lib::ajaxRespond(false, 'Sản phẩm hiện tại đang hết hàng! Bạn có thể lựa chọn sản phẩm khác');
            }
            $msg = '';
            if($replace){
                $foodCart = 0;
            }else {
                $foodCart = Cart::getInstance()->get($request->id);
                $foodCart = (!empty($foodCart) && !empty($foodCart['quan'])) ? $foodCart['quan'] : 0;
            }
                $opt = [
                    'po' => $detailObj->priceStrike,
                    'img' => $detailObj->basicInfo->image,
                ];
                if(!empty($request->opt) && is_array($request->opt)) {
                    foreach($request->opt as $k => $v){
                        $opt[$k] = $v;
                    }
                }
                $result = Cart::getInstance()->add($detailObj->id, $detailObj->basicInfo->title, $filter_ids, $quan, $detailObj->sale_price, $opt, $replace);
                if($result === true) {
                    
                    if($call_only) {
                        return true;
                    }else {
                        $content = Cart::getInstance()->content();
                        return \Lib::ajaxRespond(true, 'success', $this->cartMixConent($content));
                    }
                }else {

                    $msg = $result === 0 ? __('site.khongtimthaythongtinsanpham') : __('site.soluongvuotqua').': '.Cart::$limitPerItem;
                }
            if($call_only) {
                return true;
            }else {
                $content = Cart::getInstance()->content();
                return \Lib::ajaxRespond(false, $msg, $this->cartMixConent($content));
            }
        }
        if($call_only) {
            return true;
        }else {
            return \Lib::ajaxRespond(false, __('site.khongtimthaythongtinsanpham'));
        }
    }


    public function login(Request $request){
        if(!\Auth::guard('customer')->check()){
            $customer = Customer::where('email', $request->email)->first();
            if(!empty($customer)) {
                if($customer->active > 0) {
                    if($customer->status > 0) {
                        if (\Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                            $request->session()->regenerate();
                            return \Lib::ajaxRespond(true, 'success', ['url' => route('home')]);
                        }
                        return \Lib::ajaxRespond(false, 'error', 'LOGIN_FAIL');
                    }
                    return \Lib::ajaxRespond(false, 'error', 'BANNED');
                }
                return \Lib::ajaxRespond(false, 'error', 'NOT_ACTIVE');
            }
            return \Lib::ajaxRespond(false, 'error', 'NOT_EXISTED');
        }
        return \Lib::ajaxRespond(false, 'error', 'LOGINED');
    }

    public function register(Request $request){
        $validate = \Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/|confirmed'
            ],
            [
                'email.required' => __('site.chunhapemail'),
                'email.email' => __('site.emailkhonghople'),
                'password.required' => __('site.chuanhapmatkhau'),
                'password.min' => __('site.matkhauphaicotoithieu6kitu'),
                'password.regex' => __('site.matkhauphaibaogomchusovakitudacbiet'),
                'password.confirmed' =>  __('site.xacthucmatkhaukhongkhop'),
            ]
        );
        if ($validate->fails()) {
            return \Lib::ajaxRespond(false, 'error', $validate->errors()->all());
        }elseif(\Lib::isWeakPassword($request->password)){
            return \Lib::ajaxRespond(false, 'error', [__('site.matkhauquayeu')]);
        }

        $customer = Customer::where('email', $request->email)->first();
        if($customer){
            return \Lib::ajaxRespond(false, 'error', 'EXISTED');
        }
        $customer = Customer::createOne($request);
//        /*Add to crm customer*/
//        $crmCustomer = new CRMLib();
//        $crmCustomer->sendCustomerInfo($customer);
//        /*End add*/

        //gui email
        event( "customer.register", [$customer->id,\Lib::getDefaultLang()]);
        return \Lib::ajaxRespond(true, 'success', ['url' => route('register.success').'?email='.$customer->email]);
    }

    public function emailActive(Request $request){
        $customer = Customer::find($request->id);
        if($customer){
            $customer->token->newToken();

            event('customer.register.resend', [$customer->id,\Lib::getDefaultLang()]);

            return \Lib::ajaxRespond(true, 'success');
        }
        return \Lib::ajaxRespond(false, __('site.nguoidungkhongtontaihoacdabikhoa'));
    }

    public function subscribe(Request $request){
        $data = $request->form;
        foreach ($data as $v){
            $result[$v['name']] = $v['value'];
        }
        
        // fix tạm
        $capcha = isset($result['contact_footer']) ? true : GGCapcha::getInstance()->verifyv2($result['g-recaptcha-response']);

        // dd($request->input('g-recaptcha-response'));
        if($capcha == true) {
            $validate = \Validator::make(
                $result,
                [
                    'fullname' => 'required|max:50',
                    'phone' => ['required', 'numeric'],
                    'email' => 'required|email',
                ],
                [
                    'fullname.required'  => 'Hãy nhập họ tên của bạn !!!',
                    'phone.required'     => 'Hãy nhập số điện thoại của bạn !!!',
                    'email.required' => 'Bạn chưa nhập Email !!!',
                    'email.email' => 'Định dạng Email không đúng !!!',
                ]
            );
            if($validate->fails()){
                return \Lib::ajaxRepond(false, 'error', $validate->errors()->all());
            }

            if(\Lib::is_valid_email($result['email'])) {
                $subscriber = new Subscriber();
                $subscriber->email = !empty($result['email']) ? $result['email'] : '';
                $subscriber->fullname = !empty($result['fullname']) ? $result['fullname'] : '';
                $subscriber->title = !empty($result['title_product']) ? $result['title_product'] : '';
                $subscriber->phone = !empty($result['phone']) ? $result['phone'] : '';
                $subscriber->address = !empty($result['address']) ? $result['address'] : '';
                $subscriber->content = !empty($result['content']) ? json_encode($result['content']) : '';
                $subscriber->recaptcha = !empty($result['g-recaptcha-response']) ? ($result['g-recaptcha-response']) : '';
                $subscriber->created = time();
                $subscriber->type = !empty($result['type']) ? $result['type'] : '1';
                $customer = Customer::where('email', $result['email'])->first();

                $dataEmail = array(
                    'name'=> $result['fullname'],
                    'email'=> $result['email'],
                    'phone'=> $result['phone'] ,
                    'address' => $result['address'] ,
                    'type'=> $result['type'] ,
                    'content'=> $result['content'],
                );
                event('customer.sendmail', ['data' => $dataEmail]);

                if (!empty($customer)) {
                    $subscriber->customer_id = $customer->id;

                    //update thong tin khach hang
                    $customer->phone = $subscriber->phone;
                    $customer->fullname = $subscriber->fullname;
                    $customer->save();
                }
                $subscriber->save();
                return \Lib::ajaxRespond(true, __('site.camonbandadangkyyeucaucuabandaduocghinhan'));
            }
            return \Lib::ajaxRespond(false, __('site.emailkhonghople'));
        }else {
            return \Lib::ajaxRespond(false, 'Bạn vui lòng thử lại, hãy chắc chắn không phải robot!');
        }
    }

    public function subscribeSale(Request $request){
        $data = $request->form;
        foreach ($data as $v){
            $result[$v['name']] = $v['value'];
        }
        $validate = \Validator::make(
            $result,
            [
                'fullname' => 'required|max:50',
                'phone' => ['required', 'numeric'],
                'email' => 'required|email',
            ],
            [
                'fullname.required'  => 'Hãy nhập họ tên của bạn !!!',
                'phone.required'     => 'Hãy nhập số điện thoại của bạn !!!',
                'email.required' => 'Bạn chưa nhập Email !!!',
                'email.email' => 'Định dạng Email không đúng !!!',
            ]
        );
        if($validate->fails()){
            return \Lib::ajaxRepond(false, 'error', $validate->errors()->all());
        }
        if(\Lib::is_valid_email($result['email'])) {
            $subscriber = new Purchase;
            
            $giaxe      = str_replace(',', '', str_replace('.', '', str_replace('VNĐ', '', $result['gia_xe'])));
            $tratruoc   = str_replace(',', '', str_replace('.', '', str_replace('VNĐ', '', $result['tra_truoc'])));
            $laisuat    = $result['lai_suat'] ;

            //trả mỗi tháng = ((giá máy - trả trước) / số tháng) + ((giá máy - trả trước) * (% tháng / 100 )) + phụ phí
            $price_purchase = ceil( (($giaxe - $tratruoc) / $result['thoi_han_vay']) + (($giaxe - $tratruoc) * ((str_replace(',', '.', $laisuat)  * 100) / 10000)) );
            $subscriber->price_purchase = $price_purchase;
            $subscriber->email = $result['email'];
            $subscriber->title = $result['title_product'] ?? '';
            $subscriber->address = $result['address'] ?? '';
            $subscriber->giaxe = $giaxe ?? '';
            $subscriber->tratruoc = $tratruoc ?? '';
            $subscriber->laisuat = $result['lai_suat'] ?? '' ;
            $subscriber->thoihanvay = !empty($result['thoi_han_vay']) ? $result['thoi_han_vay'] : '12';
            $subscriber->fullname = !empty($result['fullname']) ? $result['fullname'] : '';
            $subscriber->title = !empty($result['title_product']) ? $result['title_product'] : '';
            $subscriber->phone = !empty($result['phone']) ? $result['phone'] : '';
            $subscriber->recaptcha = !empty($result['g-recaptcha-response']) ? ($result['g-recaptcha-response']) : '';
            $subscriber->created = time();
            $subscriber->type = 99;
            

            $dataEmail = array(
                'tra_hang_thang'=> $price_purchase,
                'giaxe'=> $giaxe,
                'laisuat'=> $laisuat,
                'tratruoc'=> $tratruoc,
                'titleProduct'=> $result['title_product'] ?? '',
                'thoihanvay'=> $result['thoi_han_vay'],
                'name'=> $result['fullname'],
                'email'=> $result['email'],
                'phone'=> $result['phone'] ,
            );
            event('customer.RequestMailSale', ['data' => $dataEmail]);
            $subscriber->save();

          
            return \Lib::ajaxRespond(true, __('site.camonbandadangkyyeucaucuabandaduocghinhan'));
        }
        return \Lib::ajaxRespond(false, __('site.emailkhonghople'));
    }
    

    public function subscribeContribute(Request $request){
        $data = $request->data;
        foreach ($data as $v){
            $result[$v['name']] = $v['value'];
        }
        $validate = \Validator::make(
            $result,
            [
                'fullname' => 'required|max:50',
                'address' => 'required',
                'phone' => ['required', 'numeric']
            ],
            [
                'fullname.required'  => 'Hãy nhập họ tên của bạn !!!',
                'address.required' => 'Bạn chưa nhập địa chỉ !!!',
                'phone.required'     => 'Hãy nhập số điện thoại của bạn !!!'
            ]
        );
        if($validate->fails()){
            return \Lib::ajaxRepond(false, 'error', $validate->errors()->all());
        }
            $subscriber = new SubscriberContribute();
            
            $subscriber->fullname = !empty($result['fullname']) ? $result['fullname'] : '';
            $subscriber->address = !empty($result['address']) ? $result['address'] : '';
            $subscriber->phone = !empty($result['phone']) ? $result['phone'] : '';
            $subscriber->created = time();
            $subscriber->save();
            return \Lib::ajaxRespond(true, __('site.camonbandadangkyyeucaucuabandaduocghinhan'));
    }

    public function updateRoute(){
        $routes = \Lib::saveRoutes();
        return \Lib::ajaxRespond(true, 'ok', $routes);
    }

    protected function cartMixConent(&$content = []){
        if (\Auth::guard('customer')->check()) {
            $content['customer_id'] = \Auth::guard('customer')->id();
        } else {
            $content['url_login'] = route('login');
        }
        return $content;
    }

    public function checkCoupon(Request $request){
        if(!empty($request->coupon)){
            $giftLib = new CouponLib();
            $cart_content = Cart::getInstance()->content();
            // dd($cart_content);
            $checking['category'] = DetailInfoProduct::getAllCateFromPrdIds($cart_content['itm_ids']);
            $checking['product'] = $cart_content['itm_ids'];
            $coupon = $giftLib->checking_coupon_by_cus($request->coupon,$checking);
            if(!empty($coupon)) {

                $return_coupon = CouponLib::calcCoupon($request->coupon,$cart_content['total'],$cart_content);
                $cart_content['grand_total'] = isset($return_coupon['grand_total']) && $return_coupon['grand_total'] > 0 ? $return_coupon['grand_total'] : $cart_content['total'];
                if($cart_content['grand_total'] > @\Lib::getSiteConfig('free_ship')) {
                    $cart_content['shipping_fee'] = 0;
                }
                $cart_content['grand_total'] += $cart_content['shipping_fee'];
                $return_data = [
                    'coupon_info' => $coupon,
                    'total_cart' => $cart_content['total'],
                    'total_after_coupon' => $cart_content['grand_total'],
                    'dccoupon' => $return_coupon['dccoupon'],
                ];
                return \Lib::ajaxRespond(true, 'Available', $return_data);
            }
        }

        return \Lib::ajaxRespond(false,"Mã coupon không hợp lệ hoặc đã được sử dụng");
    }

    public function nothing(){
        return "Nothing...";
    }

    public function checkComment(Request $request)
    {
        $data = $request->form;
        foreach ($data as $v){
            $result[$v['name']] = $v['value'];
        }
        $comment = new Comment;
        $comment->comment = $result['content'];
        $comment->comment_parent = $result['id_cmt'] ?? '0';
        $comment->customer_name = $result['fullname'];
        $comment->age = $result['age'] ?? 0;
        $comment->phone = $result['phone'];
        $comment->type = 1;
        $comment->status = 1;
        $comment->type_id =  $result['prd_id'] ?? '0';
        $comment->created =  time();
        $comment->tableName =  $result['tableName'];
        $comment->url = $result['current_url'];
        $comment->save();
        // return redirect()->back();
    }
}
