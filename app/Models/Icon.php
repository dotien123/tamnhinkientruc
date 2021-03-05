<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    //
    protected $table = 'icon';

    public $timestamps = false;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DRAFF = -2;
    protected $fillable = ['status', 'id', 'title'];
   
    const SIZE = [
        'big_home' => ['width' => 700, 'height' => 700],

        'fae_home' => ['width' => 300, 'height' => 300],
    ];

    public static function getSize($type = 'big_home'){
        if(isset(self::SIZE[$type])){
            return (object)self::SIZE[$type];
        }
        return false;
    }

    public function getImageUrl($size = 'original', $filed = 'image'){
        return \ImageURL::getImageUrl($this->$filed, 'icon', $size);
    }

    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public static function getIcontop()
    {
        return self::where([['status', 1], ['position', 0]])->take(4)->get();
    }

    public static function getIconbottom()
    {
        return self::where([['status', 1], ['position', 1]])->take(4)->get();
    }

}
