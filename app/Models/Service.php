<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    public $timestamps = false;

    public function getImageUrl($size = 'original', $field = 'image'){
        return \ImageURL::getImageUrl($this->$field, 'service', $size);
    }

    public static function getAllServices() {
        $order = 'created DESC, id DESC';
        $cond[] = ['status', '>', 1];
        return self::where($cond)->orderByRaw($order)->get();
    }
}