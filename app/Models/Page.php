<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    const table_name = 'page_static';
    protected $table = self::table_name;
    public $timestamps = false;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DRAFF = -2;
    public static $type = [
        0 => 'Comment',
        1 => 'Hiển thị trong menu Footer'
    ];


    public static function getCommentRankNewsById($id){

        $data = \DB::table('page_static')
            ->leftJoin('news_detail', 'news_detail.new_id', '=', 'page_static.id')
            ->leftJoin('comments', [['comments.new_id', '=', 'page_static.id'], ['comments.new_detail_id', '=', 'news_detail.id']])
            ->where([['page_static.status', '>', 1], ['page_static.id', $id], ['news_detail.type', 3]])
            ->select(\DB::raw("COUNT(news_detail.new_id) as rank"), \DB::raw("COUNT(comments.new_id) as comments"), \DB::raw("SUM(news_detail.vote) as vote"))
            ->groupBy('news_detail.new_id')->first();
        return $data;
    }

    public function getLink($admin = 0){
        if($admin){
            return env('APP_URL').'/static/'.$this->link_seo;
        }
        return route('trangtinh', ['link_seo' => str_slug($this->link_seo)]);
    }

    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }
    public function type(){
        return isset(self::$type[$this->type]) ? self::$type[$this->type] : '---';
    }

    public static function updateViewNews($id) {
        // dd(self::where($id), $id);
        return self::find($id)->increment('views', 1);
    }

    public function getAllLink($keyByLink = false, $type = [0]){
        $allPage = Page::whereStatus(2)
            ->whereLang(\Lib::getDefaultLang())
            ->whereIn('type', $type)
            ->select('link_seo','id','title')
            ->orderByRaw('sort desc, id desc')
            ->get();
        $return = [];
        if(!empty($allPage)){
            foreach ($allPage as $p){
                if($keyByLink){
                    $return[$p->link_seo] = $p;
                }else {
                    $return[$p->title] = $p->getLink();
                }
            }
        }
        return $return;
    }

    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image, 'page', $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'page', $size);
    }

    public static function getListNewsPageStatic(){
        $data = self::where('status', self::STATUS_ACTIVE)->orderBy('published','DESC')->get();
        if(!empty($data)){
            return $data;
        }
        return false;
    }
}

