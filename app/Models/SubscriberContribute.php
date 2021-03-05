<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class SubscriberContribute extends Model
{
    protected $table = 'subscribers_contribute';
    public $timestamps = false;
    protected $fillable = ['fullname' , 'email' , 'phone' , 'address' ,  'title' , 'content' , 'total_money'];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_REMOVE = -1;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const KEY = 'subscriber_contribute';
    public function province(){
        return $this->belongsTo(GeoProvince::class, 'province_id' , 'id');
    }

//    public function getImageUrl($field = 'image' , $size = 'original'){
//        return \ImageURL::getImageUrl($this->$field, self::KEY, $size);
//    }
}