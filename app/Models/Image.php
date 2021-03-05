<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    const table_name = 'image';
    protected $table = self::table_name;
    public $timestamps = false;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DRAFF = -2;
    protected $fillable = ['status', 'removed', 'id', 'title'];
    // const OPTIONS = [
    //     'big_home' => 'Banner to website - 1300x611 px',

    //     'fae_home' => 'Trang chủ FAE - 600x398 px'
    // ];

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
        return \ImageURL::getImageUrl($this->$filed, 'image', $size);
    }

    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public static function getSlides($position = '-1', $lang = '', $limit = 0){
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $data = self::where('lang', $lang)
            ->where('status', self::STATUS_ACTIVE)
            ->where('positions', 'LIKE', '%'.$position.'%')->orderBy('created','DESC');
        if($limit > 0){
            $data = $data->limit($limit);
        }
        return $data->get();
    }
    

    public static function getSlidesCate($position = '-1', $lang = '', $limit = 0){
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $data = self::where('lang', $lang)
            ->where('status', self::STATUS_ACTIVE)
            ->where('positions_cate', 'LIKE', '%'.$position.'%');
        if($limit > 0){
            $data = $data->limit($limit);
        }
        return $data->get();
    }

    public static function getSlideByLang($lang = 'vi'){
        return self::where([
            ['lang', '=', $lang],
            ['status', '>', 0],
        ])->get();
    }

    public function positions(){
        $all = explode(',', $this->positions);
        if(!empty($all)){
            $tmp = [];
            $menu = \Menu::getMenu(3);
            foreach ($all as $a){
                if ($a == -1) {
                    $tmp[-1] = ['title' => 'Trang chủ'];
                }
                if ($a == -99) {
                    $tmp[-99] = ['title' => 'Trang chủ Mobile'];
                }
                if ($a == -2) {
                    $tmp[-2] = ['title' => 'Footer'];
                }
                if(isset($menu['_'.$a])){
                    $tmp[$a] = $menu['_'.$a];

                }
            }

            return $tmp;
        }
        return false;
    }
}
