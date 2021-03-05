<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{
    //
    static $TYPE_ORDER = 'order';
    static $TYPE_CATEGORY = 'category';
    static $TYPE_PRODUCT = 'product';
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    protected $table = 'coupons';
    public $timestamps = false;

    public $fillable = ['code','type','value','started','expired','user_id','created','id','used_times','quantity','removed','status'];

    public static function listType() {
        $TYPE = [
            self::$TYPE_ORDER => 'Đơn hàng',
            // self::$TYPE_CATEGORY => 'Danh mục',
            self::$TYPE_PRODUCT => 'Sản phẩm'
        ];
        return $TYPE;
    }

    public static function listTypeObject() {
        $TYPE = [
            self::$TYPE_ORDER => [
                'title' => 'Đơn hàng',
                'id' => self::$TYPE_ORDER,
            ],
            // self::$TYPE_CATEGORY => [
            //     'title' => 'Danh mục',
            //     'id' => self::$TYPE_CATEGORY,
            // ],
            self::$TYPE_PRODUCT => [
                'title' => 'Sản phẩm',
                'id' => self::$TYPE_PRODUCT,
            ],
        ];
        return $TYPE;
    }

    

    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public function type() {
        if(in_array($this->type,array_keys(self::listType()))) {
            return self::listType()[$this->type];
        }
        return __('site.khongxacdinh');
    }

    public function user(){
        return $this->belongsTo('App/Model/User','user_id');
    }

    public static function couponCanUse($coupon,$type = 'hotel') {
        return self::where('code',$coupon)
            ->where('status',1)
            ->where('expired', '>', time())->first();
    }

    public static function getCoupons(){
        $sql[] = ['status', '>', 0];

        $data = self::where($sql)
        ->orderByRaw('id DESC')
            ->get()
            ->keyBy('id');
        return $data;
    }
    public static function getCouponsPublic($phone = ''){
        $data = self::where('status', '>', 0);
        $data->where('public', 1);

        $data->where(function ($q) use ($phone) {
            $q->where('public', 1);
            if($phone != '') {
                $q->orWhere('phone_customer', $phone);
            }
        });

        $data->where('expired', '>', time());
        $data->where('quantity', '>', 0);
        $data->orderByRaw('value DESC');
        $data->limit(10);
        return $data->get()->keyBy('id');
    }

}
