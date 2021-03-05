<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //
    protected $table = 'bank';
    public $timestamps = false;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $fillable = ['name', 'removed', 'status', 'created', 'account', 'bank', 'branch'];

    public function getImageUrl($size = 'original', $mobile = false){
        return \ImageURL::getImageUrl($mobile ? $this->image_mobile : $this->image, 'bank', $size);
    }
    public function getInfor() {
        return $this->bank.'; '.__('site.chutaikhoan').': '.$this->name.'; '.__('site.sotaikhoan').': '.$this->account.'; '.__('site.chinhanh').': '.$this->branch;
    }

    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public static function getBankByLang($lang = 'vi'){
        return self::where([
            ['lang', '=', $lang],
            ['status', '>', 0],
        ])->get();
    }

    public static function getBankKeyBy($key = 'id'){
        return self::where([
            ['status', '>', 0],
        ])->get()->keyBy($key);
    }
}
