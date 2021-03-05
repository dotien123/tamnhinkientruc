<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Purchase extends Model
{
    protected $table = 'purchase';
    public $timestamps = false;
    protected $fillable = ['fullname' , 'email' , 'phone' , 'address' ,  'title' , 'recaptcha', 'type', 'price_purchase', 'tratruoc', 'laisuat', 'thoihanvay'];
    const STATUS_ACTIVE = 1;

    
    static function getTableSubcribeNewLetter()
    {
        return DB::table('subscribers_newsletter');
    }
}
