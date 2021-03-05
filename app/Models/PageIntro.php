<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageIntro extends Model
{
    const table_name = 'page_intro';
    protected $table = self::table_name;
    protected static $type = [
        '1' => 'Giới thiệu',
        '3' => 'Lĩnh vực kinh doanh',
        '4' => 'Hoạt động công ty',
        
    ];

    public $timestamps = false;
    const KEY = 'page_intro';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_REMOVE = -1;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;

    protected $fillable = ['title' , 'id', 'alias', 'status', 'content', 'image' , 'title_seo' , 'description_seo' , 'keywords' , 'robots' , 'image_seo'];

    public function getImageUrl($field = 'image' , $size = 'original'){
        return \ImageURL::getImageUrl($this->$field, self::KEY, $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, self::KEY, $size);
    }

    public function intro_detail()
    {
        return $this->hasOne(IntroDetail::class, 'intro_id', 'id');
    }

    public static function tabIntroduct()
    {
       return self::where([['type', 1],['status', 1]])->take(4)->orderBy('sort', 'asc')->get();
    }

    public static function tabBusiness()
    {
       return self::where([['type', 3],['status', 1]])->take(3)->orderBy('sort', 'asc')->get();
    }

    public static function tabWork()
    {
        return self::where([['type', 4],['status', 1]])->orderBy('id', 'DESC')->paginate(12);
    }
    
    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }
    public static function getListNewsFormFooter(){
        $data = self::where('status',self::STATUS_ACTIVE)->orderBy('sort','DESC')->get();
        if(!empty($data)){
            return $data;
        }
        return false;
    }
    public static function getType(){
        return self::$type;
    }

    public function getIntroByType($type)
    {
        $data = self::where('type',$type)->orderBy('sort','DESC')->first();
        return $data;
    }

}