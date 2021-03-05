<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Subscriber extends Model
{
    protected $table = 'subscribers';
    public $timestamps = false;
    protected $fillable = ['fullname' , 'email' , 'phone' , 'address' ,  'title' , 'content', 'recaptcha', 'type'];
    const STATUS_ACTIVE = 1;

    public function province(){
        return $this->belongsTo(GeoProvince::class, 'province_id' , 'id');
    }


    static function getTableSubcribeNewLetter()
    {
        return DB::table('subscribers_newsletter');
    }
}
