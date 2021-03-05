<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ConfigHome extends Model
{
    protected $table = 'config_home';
    public $timestamps = false;

    public static function getColorSize($type = 'color') {
        return self::where('type', $type)->get()->keyBy('id')->toArray();
    }

    public function getImageUrl($k = 'image', $size = 'original'){
        return \ImageURL::getImageUrl($this->$k, 'confighome', $size);
    }

}