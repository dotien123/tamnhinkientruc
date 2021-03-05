<?php
/**
 * Created by PhpStorm.
 * User: Kayn
 * Date: 14/04/20
 * Time: 1:02 PM
 */

namespace App\Libs;
use Illuminate\Support\Facades\Session;
class Cart
{
    static private $instance = false;
    static public $viewVar = [];
    protected $key = 'ShopCart';
    const TYPE_ORDER = 'order';
    const TYPE_PRODUCT = 'product';
    public function __construct()
    {
        self::$instance = &$this;
        $this->restore();
    }

    public static function &getInstance()
    {

        if (!self::$instance) {
            new self();
        }
        return self::$instance;
    }

    /*
     * Kịch bản:
     * 1. Thêm vào giỏ hàng
     *  1.1: Kiểm tra sản phẩm đó đã tồn tại hay chưa
     *    1.1.1: Nếu có thì update số lượng
     *    1.1.2: Nếu không thì sang 2.
     *  1.2: không có thì thêm
     * */

    public function get($key = '', $product = true){
        if($product) {
            return $this->cart->get('details')->get($key);
        }
        return $this->cart->get($key);
    }

    public function add($data) {
        $details = $this->get('details', false);
        $currentObj = $this->get($data['sku'], true);
        if(isset($currentObj)) {
            $currentObj['quantity'] = $data['quantity'];
            $resUpdated = $this->updateDetail($currentObj);
            if(!$resUpdated) {
                return false;
            }
        }else {
            $details->put($data['sku'], $data);
        }
        $resTotal = $this->calcTotalCart();
        $resGrandTotal = $this->calcGrandTotalCart();
        $resquantity = $this->calcquantity();
        if($resTotal && $resquantity && $resGrandTotal) {
            $this->store();
        }else {
            return false;
        }
        return true;
    }

    public function remove($sku = 0){

        $existed = $this->get($sku, true);
        if(isset($existed)) {
            $this->cart->get('details')->forget($existed);
            $this->refresh();

            $this->store();
            return true;
        }
        return false;
    }

    protected function refresh(){
        $total = 0;
        $grandTotal = 0;
        $number = 0;
        $itm_ids = [];
        $details = $this->cart->get('details');
        $ship_fee = isset($this->cart->shipping_fee) ? $this->cart->shipping_fee : 0;
        if(!empty($details)){
            $grandTotal += $ship_fee;
            foreach ($details as $item){
                $total += $item['sale_price'] * $item['quantity'];
                $number+= $item['quantity'];
            }
            $grandTotal += $total;
        }
        $this->cart->put('details',collect(array_values($details->toArray())));
        $this->cart->put('total', $total);
        $this->cart->put('grandTotal', $grandTotal);
        $this->cart->put('number', $number);
    }


    /*
     * Cộng từng tổng tiền của từng đơn hàng, chưa có coupon
     * là tk tạm tính
     * */
    private function calcTotalCart() {
        $details = $this->get('details', false);
        if ($details) {
            $total = 0;
            foreach ($details as $detail) {
                $total += $detail['sale_price']*$detail['quantity'];
            }
            $this->cart->put('total', $total);
            return true;
        }
        return false;
    }

    /*
     * Cộng tiền của từng đơn hàng + cả coupon
     * là tk thành tiền
     * @todo @kayn Chưa tính coupon, mới cộng tiền của tất cả đơn hàng
     * */
    private function calcGrandTotalCart() {
        $details = $this->get('details', false);
        if ($details) {
            $grandTotal = 0;
            foreach ($details as $detail) {
                $grandTotal += $detail['sale_price']*$detail['quantity'];
            }
            $this->cart->put('grandTotal', $grandTotal);
            return true;
        }
        return false;
    }

    private function calcquantity() {
        $details = $this->get('details', false);
        if ($details) {
            $number = 0;
            foreach ($details as $detail) {
                $number += $detail['quantity'];
            }
            $this->cart->put('number', $number);
            return true;
        }
        return false;
    }

    public function getTotal() {
        return $this->get('total', false);
    }

    private function updateDetail($currentObj) {
        $details = $this->get('details', false);
        if($details) {
            $details->put($currentObj['sku'], $currentObj);
            return true;
        }
        return false;
    }

    private function store() {
        $cart = $this->cart->toArray();
        session([$this->key => json_encode($cart)]);
    }

    private function restore() {
        $cart = [];
        $tmp = session($this->key);
        if(!empty($tmp) && $tmp != '%5B%5D') {
            $tmp = json_decode($tmp,1);
            if(!empty($tmp)) {
                $cart = $this->dataCart($tmp['details'], $tmp['total'], $tmp['number'], @$tmp['grandTotal']);
            }
        }
        if(empty($cart)){
            $cart = $this->dataCart();
        }
        $this->cart = $cart;
    }

    public function content() {
        $data = $this->cart->toArray();
        return $data;
    }

    /*
     * Dữ liệu khởi tạo gồm:
     * 1. Danh sách sản phẩm
     * 2. Tổng tiền cả giỏ hàng
     * 3. Số lượng sản phẩm có trong giỏ
     * */

    private function dataCart($details = [], $total = 0, $number = 0, $grandTotal = 0) {
        if(empty($details)){
            $details = [];;
        }
        return collect(['details' => collect($details),
            'total' => $total,
            'grandTotal' => $grandTotal,
            'number' => $number,
        ]);
    }
}