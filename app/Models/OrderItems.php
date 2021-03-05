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

class OrderItems extends Model
{
    protected $table = 'order_items';
    public $timestamps = false;
    public $fillable = ['order_id', 'title', 'price', 'quantity'];

    public function size() {
        return $this->hasOne('App\Models\ColorSize', 'id', 'size_id');
    }
    public function color() {
        return $this->hasOne('App\Models\ColorSize', 'id', 'color_id');
    }

    public function product() {
        return $this->hasOne('App\Models\DetailInfoProduct','id','product_id');
    }

    public static function getIdsProductYeuThich() {
        return 0;
    }

    public static function returnOrderItemObjs($items,$order_id) {
        $arr = [];
        foreach($items as $itm) {
            $obj_bookingitem = new self();
            $obj_bookingitem->order_id = $order_id;
            $obj_bookingitem->product_id = $itm['id'];
            $obj_bookingitem->title = @$itm['name'] ?? @$itm['title'];
            $obj_bookingitem->price = $itm['price'];
            $obj_bookingitem->quantity = @$itm['quan'] ?? @$itm['quantity'];
            $obj_bookingitem->images = @$itm['opt']['img_or'] ?? @$itm['image'];
            $obj_bookingitem->note = @$itm['opt']['opt']['note'] ?? '';
            $obj_bookingitem->opts = @$itm['filter'] ? json_encode($itm['filter']) : '';
            $obj_bookingitem->filter_ids = @$itm['filter_key'];
            $obj_bookingitem->size_id = @$itm['filter']['size']['id'];
            $obj_bookingitem->color_id = @$itm['filter']['color']['id'];
            // $obj_bookingitem->coupon = @$itm['filter']['color']['id'];

            $arr[] = $obj_bookingitem;
        }
        return $arr;
    }
}