<?php

namespace App\Models;

use App\Models\TagDetail;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class News extends Model
{
    //
    const table_name = 'news';
    protected $table = self::table_name;
    public $timestamps = false;
    const KEY = 'news';
    const NUM_KEY = 1;
    const VIEWS = 0;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DRAFF = -2;
    const KEY_COOKIE_NEWS_HISTORY = 'COOKIE_HISTORY_NEW_';

    protected $fillable = ['status', 'removed', 'id', 'alias', 'title'];

    public function categories(){
        return $this->belongsToMany(Category::class, 'news_categories', 'new_id', 'cate_id');
    }
    
    public function category(){
        return $this->hasOne(Category::class, 'id', 'cate_primary');
    }

    public function authors(){
        return $this->hasOne('App\Models\User', 'id', 'author');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'tag_details', 'object_id', 'tag_id');
    }

    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image, 'news', $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'news', $size);
    }

    public function getLink(){
        return self::getLinkDetail($this->title_seo, $this->id);
    }

    public static function getType($cat_id){
        $cate = self::with('category')->where('cat_id', $cat_id)->first();
        if($cate) {
            return $cate->category->title;
        }
        // dd($cat_id, $cate);
        return Category::where('id', $cat_id)->first()->title;
    }

    

    public static function getLinkDetail($title_seo = '', $id = 0, $type = 'news', $cat_id = 0){
        return route($type.'.detail', ['safe_title' => str_slug($title_seo), 'id' => $id, 'cat_id' => $cat_id]);
    }

    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }


    public static function getListNew($lang = 'vi', $limit = 7, $except = '', $type = 'all'){
        $cond = [
            ['status', '=', self::STATUS_ACTIVE],
            ['published', '>', 0],
            ['lang', '=', $lang],
        ];

        $data = self::select('id', 'title', 'title_seo', 'image', 'alias','created','description')
            ->where($cond);
        if(!empty($except)){
            if(!is_array($except)){
                $except = [$except];
            }
            $data = $data->whereNotIn('id', $except);
        }
        return $data->orderBy('published', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getAllNews($limit) {
        return self::where('status', self::STATUS_ACTIVE)->orderBy('published', 'desc')->paginate($limit);
    }

    public static function getRandNews() {
        return self::where('status', self::STATUS_ACTIVE)->orderBy('published', 'desc')->inRandomOrder()->limit(3)->get();
    }


    public static function getLatestPost4AllCate($limit = 10, $lang = 'vi') {
        $data = self::with(['categories' => function($q) {
            $q->select('title', 'safe_title', 'id')->where('categories.status', '>', '0')->get();
        }])->with(['category' => function($c) {
            
            $c->select('title', 'safe_title', 'id')->where('categories.status', '>', '0')->get();
        }])->select('news.id', 'news.title', 'news.image', 'news.alias', 'news.cate_primary')
            ->where([
                 ['news.status', self::STATUS_ACTIVE],
                 ['news.published', '>', '0'],
            ])->inRandomOrder()->limit($limit)->get();
        return $data;
     }
     

    public static function getAllNewsByCate($cat_id, $pagi = 10, $child = true){
        if($cat_id > 0) {
            $data = self::leftJoin('news_categories', 'news_categories.new_id', '=', 'news.id')
                ->leftJoin('categories', 'categories.id', '=', 'news_categories.cate_id')
                ->where([
                    ['categories.status', '>', '0'],
                    ['categories.id', $cat_id]
                ]);
            $data = $data->select('news.id', 'news.title', 'news.image', 'news.alias', 'news.description', 'news.published','news_categories.cate_id')
            ->where([
                ['news.status', self::STATUS_ACTIVE],
                ['news.published', '>', '0'],
            ]);
            $data = $data->orderBy('news.published', 'desc')
            ->paginate($pagi);
            return $data;
        }
    }
    public static function getRelatedNewsByCate($cat_id, $limit = 7,$id){
        if(count($cat_id)> 0) {
            $data = self::where([
                    ['news.status', '>', '0'],
                    ['news.id', '!=', $id]
                ]);
            // foreach ($cat_id as $key => $value) {
            //     if($key<1){
            //         $data = $data->where([
            //             ['categories.id', $value->id]
            //         ]);
            //     }else{
            //         $data = $data->orWhere([
            //             ['categories.id', $value->id]
            //         ]);
            //     }
            // }
            $data = $data->select('news.id', 'news.title', 'news.image', 'news.alias', 'news.description', 'news.published')
            ->where([
                ['news.status', self::STATUS_ACTIVE],
                ['news.published', '>', '0'],
            ]);
            $data = $data->orderBy('news.published', 'desc')->limit($limit)->get();
            return $data;
        }
    }
    public static function getRelatedCate($cat_id, $limit = 7, $lang = '') {
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $sql = []; $rel = [];
        $sql[] = ['lang', '=', $lang];
        $sql[] = ['status', '>', 0];

        $data = Category::where($sql)
            ->orderByRaw('type, pid, sort DESC, title')
            ->get()
            ->keyBy('id');
        $data = Category::fetchAll($data);
        if(isset($data['_'.$cat_id])) {
            $data =  $data['_'.$cat_id];
            foreach($data['sub'] as $item) {
                $rel[$item['title']] = self::getAllNewsByCate($item['id']);
            }
        }
        
        return $rel;
    }

    public static function getlistTrend($limit = 7, $lang = '') {
        // 10 bài viết đc xem nhiều nhất => trend
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $sql = []; $rel = [];
        $sql[] = ['lang', '=', $lang];
        $sql[] = ['status', self::STATUS_ACTIVE];

        $data = self::with(['category' => function($c) {
            $c->select('title', 'safe_title', 'id')->where('categories.status', '>', '0')->get();
        }])->with(['categories' => function($q) {
                    $q->select('title', 'safe_title', 'id')->where('categories.status', '>', '0')->get();
                }])->where($sql)
            ->select('news.id', 'news.title', 'news.image', 'news.alias', 'news.sort_body', 'news.views','news.cate_primary')
            ->orderBy('news.views', 'desc')
            ->limit($limit)
            ->get()
            ->keyBy('id');
       
        return $data;
    }

    public static function updateViewNews($id) {
        return self::find($id)->increment('views', 1);
    }

    public static function getAllTagsForNews($id) {
        return self::with('tags')->where('id', $id)->get();
    }
    

    public static function getAllNewsByTags($id, $lang = 'vi', $limit = 10){
        //lay toan bo tin cung tag
        $news = TagDetail::getNews($id);
        $ids = [];
        foreach($news as $item){
            if($item['object_id'] != $id && !in_array($item['object_id'], $ids)) {
                $ids[] = $item['object_id'];
            }
        }

        return self::with(['authors', 'categories'])
            ->select('news.title', 'news.sort_body', 'news.description_seo', 'news.image', 'news.alias')
            ->where([
                ['news.status', '=', self::STATUS_ACTIVE],
                ['news.published', '>', 0],
                ['news.lang', '=', $lang],
            ])
            ->whereIn('news.id', $ids)
            ->paginate($limit);
    }

    public static function getRelated($id, $limit = 3, $lang = 'vi', $cate){
        //lay toan bo danh sach tag cua tin
        $tags = TagDetail::getTags($id);
        $ids = [];
        foreach($tags as $item){
            $ids[] = $item['tag_id'];
        }
        //lay toan bo tin cung tag
        $news = TagDetail::getNews($ids);
        $ids = [];
        foreach($news as $item){
            if($item['object_id'] != $id && !in_array($item['object_id'], $ids)) {
                $ids[] = $item['object_id'];
            }
        }
        return self::select('id', 'title', 'title_seo', 'image', 'published', 'alias','cate_primary')
            ->where([
                ['status', '=', self::STATUS_ACTIVE],
                ['lang', '=', $lang],['cate_primary', '=', $cate],['id', '!=', $id]
            ])
            ->limit($limit)
            ->get();
    }

    public static function getByCate($cate_id = 0,$perpage = 10,$keyword = '') {

        $cates = $cate_id > 0 ? Category::where('status', 1)
            ->where(function ($q) use ($cate_id) {
                $q->where('id', $cate_id);
                $q->orWhere('pid', $cate_id);
            })
            ->get()->keyBy('id') : Category::where('status', 1)->get()->keyBy('id');
            $wery = \DB::table('news')
            ->select('news.title', 'news.description_seo', 'news.image', 'news.alias','news.description')
            ->where([
                ['news.status', '=', self::STATUS_ACTIVE],
                ['news.published', '>', 0],
            ]);

            if($keyword != '') {
                $wery->where('news.title','LIKE','%'.$keyword.'%');
            }
            $wery->where('news.lang', \Lib::getDefaultLang());
            if($cates && !$cates->isEmpty()) {
                array_keys($cates->toArray());
            }
            return $wery->paginate($perpage);
    }

    public static function getNewsHome()
    {
        return self::where('status', 1)->orderBy('published', 'desc')->take(4)->get();
    }

    static function getNewsByPerPage($per, $select = []) {
        return self::select($select)->where([
            ['published', '>', 0],
            ['status', self::STATUS_ACTIVE],
            ['removed', self::REMOVED_NO],['cate_primary','!=','']
        ])->orderByRaw('published DESC, id DESC')->paginate($per);
    }

    public static function prdHistory($limit = 8)
    {
        $prds_cookie = Cookie::get(News::KEY_COOKIE_NEWS_HISTORY, []);
        $prds_cookie = !empty($prds_cookie) ? unserialize($prds_cookie) : [];
        if(!empty($prds_cookie)) {

            return self::where('status', self::STATUS_ACTIVE)
                ->where('lang', \Lib::getDefaultLang())
                ->whereIn('id',$prds_cookie)
                ->limit($limit)
                ->get();
        }
        return [];
    }

    public static function savePrdAfterView($id = 0) {
        $prds_cookie = Cookie::get(News::KEY_COOKIE_NEWS_HISTORY, []);
        $prds_cookie = !empty($prds_cookie) ? unserialize($prds_cookie) : [];
        if(count($prds_cookie) > 10){
            $prds_cookie = array_splice($prds_cookie, 0, 1);

        }

        $prds_cookie[] = $id;

        $prds_cookie = serialize(array_unique($prds_cookie));
        Cookie::queue(News::KEY_COOKIE_NEWS_HISTORY, $prds_cookie, 60*24*365);
    }

    //list bai viet theo thang/nam
    public static function getTimeByMonthYear(){
        $data = \DB::table('news')->distinct()->where('status', self::STATUS_ACTIVE)
                ->select(
                    \DB::raw('MONTHNAME(FROM_UNIXTIME(published)) as month'),
                    \DB::raw('MONTH(FROM_UNIXTIME(published)) as month_num'),
                    \DB::raw('YEAR(FROM_UNIXTIME(published)) as year')
                )
                ->orderBy('published' , 'DESC')
                ->get();
        return $data;
    }

    // loc bai viet theo thang/nam khi click vao lich
    public static function getNewsByTime($month,$year){
        $news = self::where('status', self::STATUS_ACTIVE)
            ->whereRaw('MONTH(FROM_UNIXTIME(published)) = ?',[$month])
            ->whereRaw('YEAR(FROM_UNIXTIME(published)) = ?',[$year])
            ->orderBy('published' , 'DESC');
        return $news;
    }

    //loc bai viet theo day/thang/nam khi click vao lich ( lay tu ngay m1 -> selected)
    public static function getNewsByFullTime($day,$month,$year){
        $news = self::where('status', self::STATUS_ACTIVE)
            ->whereRaw('DAY(FROM_UNIXTIME(published)) >= ?',[01])
            ->whereRaw('MONTH(FROM_UNIXTIME(published)) = ?',[$month])
            ->whereRaw('YEAR(FROM_UNIXTIME(published)) = ?',[$year])

            ->whereRaw('DAY(FROM_UNIXTIME(published)) <= ?',[$day])
            ->whereRaw('MONTH(FROM_UNIXTIME(published)) = ?',[$month])
            ->whereRaw('YEAR(FROM_UNIXTIME(published)) = ?',[$year])
            ->orderBy('published' , 'DESC');
        return $news;
    }

}

