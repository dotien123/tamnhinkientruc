<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payload extends Model
{
    //
    const table_name = 'payload';
    protected $table = self::table_name;
    public $timestamps = false;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    protected static $cat = [];
    protected static $splitKey = '_';
    protected static $type = [
        '1' => 'Sản phẩm',
        '2' => 'Tin tức',
    ];

    protected $fillable = ['status', 'removed', 'id', 'alias', 'title', 'is_home', 'is_sidebar'];
    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }


    public function getImageUrl($size = 'medium'){
        return \ImageURL::getImageUrl($this->image, 'product_price', $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'product_price', $size);
    }

    public function getImageIconUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_icon, 'product_price', $size);
    }

    public function type(){
        return isset(self::$type[$this->type]) ? self::$type[$this->type] : '1';
    }

    public static function getlist()
    {
        return self::where('status',1)->get();
    }


}
