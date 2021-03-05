<?php

namespace App\Models;

use App\Libs\CouponLib;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\GeoDistrict;
use App\Models\GeoProvince;
use App\Models\GeoWard;
use App\Models\OrderItems;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = false;
    public $fillable = ['created', 'status', 'price_total', 'fullname'];
    const STATUS_NO_PAID = 0; // chưa thanh toán
    const STATUS_PENDING = 1; // đang xử lý
    const STATUS_READY_SHIP = 2; // sẵn sàng giao hàng
    const STATUS_SHIPED = 3; // đang giao hàng
    const STATUS_DELIVERED = 4; // đã giao hàng
    const STATUS_CANCELLED = -1; // đã hủy do khách ko đặt nữa, chỉ đc hủy khi chưa giao hàng
    const STATUS_RETURNED = -2; // khách feedback trả lại khi hàng đã giao do ko đúng yêu cầu
    const STATUS_FAIL_DELIVERY = -3; // Giao hàng ko thành công (do thay đổi địa chỉ hoặc người nhận boom)
    const STATUS_DELETED = -4; // đã xóa

    const CASH_PAYMENT = 'cash';    // thanh toán tiền mặt (SHIP COD)
    const BANK_TRANSFER_PAYMENT= 'bank-transfer'; // thanh toán chuyển khoản

    static function getListStatus($selected = FALSE, $status = FALSE)
    {
        $listStatus = [
            self::STATUS_NO_PAID => [
                'id' => '0', 'alias' => 'no-paid',
                'style' => 'secondary',
                'icon' => 'battery-charge.svg',
                'text' => 'Đơn mới',
                'text-action' => 'Đơn mới',
                'group-action' => [
                    self::STATUS_PENDING, self::STATUS_CANCELLED, self::STATUS_DELETED
                ]
            ],
            self::STATUS_PENDING => [
                'id' => '1', 'alias' => 'pending',
                'style' => 'warning',
                'icon' => 'balance.svg',
                'text' => 'Đang xử lý',
                'text-action' => 'Đang xử lý',
                'group-action' => [
                    self::STATUS_NO_PAID, self::STATUS_READY_SHIP, self::STATUS_CANCELLED, self::STATUS_DELETED
                ]
            ],
            self::STATUS_READY_SHIP => [
                'id' => '2', 'alias' => 'ready-ship',
                'style' => 'info',
                'icon' => 'rocket.svg',
                'text' => 'Sẵn sàng giao hàng',
                'text-action' => 'Sẵn sàng giao hàng',
                'group-action' => [
                    self::STATUS_NO_PAID, self::STATUS_SHIPED, self::STATUS_PENDING, self::STATUS_CANCELLED, self::STATUS_DELETED
                ]
            ],
            self::STATUS_SHIPED => [
                'id' => '3', 'alias' => 'shiped',
                'style' => 'info',
                'icon' => 'truck.svg',
                'text' => 'Đang giao hàng',
                'text-action' => 'Đang giao hàng',
                'group-action' => [
                    self::STATUS_FAIL_DELIVERY, self::STATUS_DELIVERED, self::STATUS_CANCELLED, self::STATUS_DELETED
                ]
            ],
            self::STATUS_DELIVERED => [
                'id' => '4', 'alias' => 'delivered',
                'style' => 'info',
                'icon' => 'check-alt',
                'text' => 'Đã giao hàng',
                'text-action' => 'Đã giao hàng',
                'group-action' => [
                    self::STATUS_RETURNED, self::STATUS_DELETED
                ]
            ],
            self::STATUS_CANCELLED => [
                'id' => '-1', 'alias' => 'cancelled',
                'style' => 'danger',
                'icon' => 'lock.svg',
                'text' => 'Đã hủy',
                'text-action' => 'Đã hủy',
                'group-action' => [
                    // chỉ xóa và tạo đơn mới
                    self::STATUS_DELETED
                ]
            ],
            self::STATUS_RETURNED => [
                'id' => '-2', 'alias' => 'returned',
                'style' => 'danger',
                'icon' => 'undo.svg',
                'text' => 'Trả hàng',
                'text-action' => 'Trả hàng',
                'group-action' => [
                    // chỉ xóa và tạo đơn mới
                    self::STATUS_DELETED
                ]
            ],
            self::STATUS_FAIL_DELIVERY  => [
                'id' => '-3', 'alias' => 'fail-delivery',
                'style' => 'danger',
                'icon' => 'warning-alt.svg',
                'text' => 'Giao hàng thất bại',
                'text-action' => 'Giao hàng thất bại',
                'group-action' => [
                    self::STATUS_DELETED
                ]
            ],
            self::STATUS_DELETED => [
                'id' => '-4', 'alias' => 'deleted',
                'style' => 'danger',
                'icon' => 'trash.svg',
                'text' => 'Đã xóa',
                'text-action' => 'Đã xóa',
                'group-action' => []
            ],
        ];
        if ($selected && isset($listStatus[$selected])) {
            $listStatus[$selected]['checked'] = 'checked';
        }elseif($status !== FALSE) {
            if(isset($listStatus[$status])) {
                return $listStatus[$status];
            }
            return false;
        }

        return $listStatus;
    }

    public static function getListPayment($selected = FALSE, $status = FALSE){
        $listPayments = [
            self::CASH_PAYMENT => [
                'style' => 'secondary',
                'icon' => 'mdi mdi-bullseye-arrow',
                'text' => 'Thanh toán khi nhận hàng',
                'text-action' => 'Thanh toán khi nhận hàng',
                'description' => 'Giao hàng tận nơi, xem hàng tại chỗ, không thích có thể đổi trả lập tức cho nhân viên giao hàng',
            ],
            self::BANK_TRANSFER_PAYMENT => [
                'style' => 'warning',
                'icon' => 'mdi mdi-comment-processing-outline',
                'text' => 'Thẻ ATM nội địa/Internet Banking',
                'text-action' => 'Thẻ ATM nội địa/Internet Banking',
                'description' => 'Thanh toán cực kì tiện lợi, nhanh chóng, và an toàn'
            ],
        ];

        if ($selected && isset($listPayments[$selected])) {
            $listPayments[$selected]['checked'] = 'checked';
        }elseif($status !== FALSE) {
            if(isset($listPayments[$status])) {
                return $listPayments[$status];
            }
            return false;
        }

        return $listPayments;
    }

    public static function paymentType($selected = FALSE, $status = FALSE){
        $options = [
            0 => __('site.tienmat'),
            1 => __('site.thanhtoanonline'),
            2 => __('site.chuyenkhoanATM'),
        ];

        if ($selected && isset($options[$selected])) {
            $options[$selected]['checked'] = 'checked';
        }elseif($status !== FALSE) {
            if(isset($options[$status])) {
                return $options[$status];
            }
            return false;
        }

        return $options;
    }
    public static function shippingNotices(){
        $options = [
            1 => __('site.cangnhanhcangtot'),
            2 => __('site.binhthuong')
        ];
        return $options;
    }

    public function province() {
        return $this->hasOne('App\Models\GeoProvince','id','province_id');
    }
    public function district() {
        return $this->hasOne('App\Models\GeoDistrict','id','district_id');
    }
    public function ward() {
        return $this->hasOne('App\Models\GeoWard','id','ward_id');
    }

    public function items() {
        return $this->hasMany('App\Models\OrderItems', 'order_id', 'id');
    }

    public static function makeCode($id = 0, $type = 'k', $lang = 'vi'){
        return $type.uniqid().$id.$lang;
    }

    protected function createOrder($data) {
        $orderItem = [];
        $lsItem = $data['details'];
        unset($data['details']);
        $orderId = self::insertGetId($data);
        foreach ($lsItem as $item) {
            $item['product_id'] = $item['id'];
            $item['order_id'] = $orderId;
            unset($item['id']);
            $orderItem[] = $item;
        }
        OrderItems::insert($orderItem);
        return true;
    }

    /*public static function createOrder($data,$type = 'order',$cart_content, $err = false){
        // dd($data, $cart_content);
        $order = new self();
        $order->type = $type;
        $order->created = time();

        $order->phone = $data->phone;
        $order->fullname = $data->fullname;
        $order->customer_id = $data->customer_id;

        $order->email = $data->email;

        $order->address = $data->address;
        $order->province_id = $data->province_id;
        $order->district_id = $data->district_id;
        $order->ward_id = @$data->ward_id;
        if(!empty($data->coupon_code)) {
            $return_coupon = CouponLib::calcCoupon($data->coupon_code,$cart_content['total'],$cart_content);
        }
        $order->price_total = isset($return_coupon['grand_total']) && $return_coupon['grand_total'] > 0 ? $return_coupon['grand_total'] : $data->total_price;
        $order->coupon_code = isset($return_coupon['grand_total']) && $return_coupon['grand_total'] > 0 ? $data->coupon_code : '';
        $order->coupon_value = isset($return_coupon['grand_total']) && $return_coupon['grand_total'] > 0 ? $return_coupon['dccoupon'] : 0;
        $order->transport_fee = (isset($data->shipping_fee) && !empty($data->shipping_fee)) ?  (isset($return_coupon['free_ship']) && $return_coupon['free_ship'] == 1) ? 0 : $data->shipping_fee : 0;
        $order->payment_type = isset($data->payment_type) && !empty($data->payment_type) ? $data->payment_type : 0;
        $order->bank_id = $data->bank_id;

        $order->status = self::STATUS_NO_PAID;
        try {
            $order->save();
            $order->code = self::makeCode($order->id, 'k', \Lib::getDefaultLang());
            if($type == 'order') {
                $order->items()->saveMany(OrderItems::returnOrderItemObjs($data->booking_items, $order->id));
            }
            $order->token_tracking = self::genTokenTracking($order->code);
            $order->save();

        }catch(\Exception $e){
            throw $e;
        }
        return $order;
    }*/


    public static function getByTokenTracking($token = '',$non_processing = false) {
        $wery = Order::where('token_tracking',$token);
        if($non_processing) {
            $wery->where('status',1);
            $wery->where('user_id',0);
        }
        $wery->with(['items','items.product','province','district','ward']);

        return $wery->first();
    }

    public static function genTokenTracking($code = '') {
        return sha1(uniqid('', true).str_random(35).$code.microtime(true));
    }

    static function init_order($id) {
        
        $name = ['Khoa', 'Doãn Chí Bình', 'Kim Bình Mai', 'Dương Chân Nhân', 'Huấn Hoa Hồng', 'Hoàng Tử Gió', 'Khá Bảnh'];
        $phone = ['08865909919', '01662112105', '0961098281', '030099001154'];
        $address = ['Tố Hữu - Hà Đông - Hà Nội', 'Trúc Bạch - Ba Đình - Hà Nội', 'Cao Thắng - Thanh Miện - Hải Dương', '85 Vũ Trọng Phụng', 'Ngõ 218 Lĩnh Nam - Thanh Trì'];
        $email = ['khoait109@gmail.com', 'hacking@gmail.com', 'back123@gmail.com', 'vono123@gmail.com', 'didtu123@gmail.com'];
        $title = $name[rand(0, count($name) - 1)];
        $province_id = rand(1, 64);
        $dis = GeoDistrict::where('Province_ID', $province_id)->get()->toArray();
        $district_id = array_rand($dis);
        $wards = GeoWard::where('District_ID', $dis[$district_id])->get()->toArray();
        $ward = array_rand($wards);
        $price_total = 0;
        for($i = 0; $i < 5; $i++) {
            $pro = BasicInfoProduct::inRandomOrder()->first();
            $quan = rand(1, 10);
            $price = $quan*$pro->detailInfo->first()->sale_price;
            $price_total += $price;
            OrderItems::insert([
                'order_id' => $id,
                'title' => $pro['title'],
                'product_id' => $pro['id'],
                'price' => $price,
                'quantity' => $quan,
                'size_id' => rand(1, 4),
                'color_id' => rand(5, 14),
                
            ]);
        }
        $orderInfo = [
            'fullname' => "#".$id.' - '.$title,
            'phone' => $phone[rand(0, count($phone) - 1)],
            'address' => $address[rand(0, count($address) - 1)],
            'email' => $email[rand(0, count($email) - 1)],
            'created' => time(),
            'code' => self::makeCode($id),
            'status' => self::STATUS_NO_PAID,
            'price_total' => $price_total,
            'province_id' => $province_id,
            'district_id' => $dis[$district_id]['id'],
            'ward_id' => $wards[$ward]['id']
        ];
        self::insert($orderInfo);
    }
}