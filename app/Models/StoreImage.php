<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreImage extends Model
{
    protected $table = 'stores_img';
    public $timestamps = false;
    public static $step = 1;

    protected $appends = [
        'img',
        'imglarge'
    ];

    public function store() {
        return $this->hasOne("\App\Models\Stores",'id','objet_id')->where('type','stores');
    }

    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image, Stores::KEY, $size);
    }

    public static function getSortInsert($lang = 'vi'){
        return self::max('sort') + self::$step;
    }

    public function getImgAttribute()
    {
        return $this->getImageUrl();
    }

    public function getImglargeAttribute()
    {
        return $this->getImageUrl('large');
    }

}