<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    const table_name = 'videos';
    protected $table = self::table_name;
    public $timestamps = false;


    public function lang($l = 'vi'){
        $lang = config('app.locales');
        return isset($lang[$l]) ? $lang[$l] : 'vi';
    }

    public function getImageUrl($size = 'medium'){
        return \ImageURL::getImageUrl($this->image, 'video', $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'video', $size);
    }

    public function getImageIconUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_icon, 'video', $size);
    }

    public static function getHome()
    {
        return self::where('status', 1)->orderBy('id', 'DESC')->take(4)->get();
    }

    // public static function getAllVideosByCate($cat_id, $pagi = 10, $child = true){
    //     if($cat_id > 0) {
    //         $data = self::with(['category' => function($c) use ($child, $cat_id) {
    //             $c->select('title', 'safe_title', 'id')->where('categories.status', '>', '0')->get();
    //         }]);
    //         if($child) {
    //             $data = $data->with(['categories' => function($q) {
    //                 $q->select('title', 'safe_title', 'id')->where('categories.status', '>', '0')->get();
    //             }])->leftJoin('videos_categories', 'videos_categories.videos_id', '=', 'videos.id')
    //                 ->leftJoin('categories', 'categories.id', '=', 'videos_categories.cate_id')
    //                 ->groupBy('videos_categories.videos_id')
    //                 ->where([
    //                     ['categories.status', '>', '0'],
    //                     ['categories.id', $cat_id]
    //                 ]);
    //         }
    //         $data = $data->select('videos.videos_id', 'videos.id', 'videos.cate_par')
    //             ->where([
    //                 ['videos.status', '>', '1'],
    //             ]);
    //         if(!$child) {
    //             $data = $data->where('videos.cate_par', $cat_id);
    //         }
    //         $data = $data->paginate($pagi);
    //         return $data;
    //     }
    // }

    // public static function getRelatedCate($cat_id, $limit = 7, $lang = '') {
    //     if(empty($lang)){
    //         $lang = \Lib::getDefaultLang();
    //     }
    //     $sql = []; $rel = [];
    //     $sql[] = ['lang', '=', $lang];
    //     $sql[] = ['status', '>', 0];

    //     $data = Category::where($sql)
    //         ->orderByRaw('type, pid, sort DESC, title')
    //         ->get()
    //         ->keyBy('id');
    //     $data = Category::fetchAll($data);
    //     if(isset($data['_'.$cat_id])) {
    //         $data =  $data['_'.$cat_id];
    //         foreach($data['sub'] as $item) {
    //             $rel[$item['title']] = self::getAllVideosByCate($item['id']);
    //         }
    //     }

    //     return $rel;
    // }

    public static function getRelated($lang = 'vi', $limit = 3, $id){
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
        return self::with(['category' => function($c) {
            $c->select('title', 'safe_title', 'id')->where('categories.status', '>', '0')->get();
        }])->with(['categories' => function($q) {
            $q->select('title', 'safe_title', 'id')->where('categories.status', '>', '0')->get();
        }])->select('id', 'title', 'title_seo', 'image', 'published', 'alias', 'cate_par')
            ->where([
                ['status', '=', 2],
                ['published', '>', 0],
                ['lang', '=', $lang],
            ])
            ->whereIn('id', $ids)
            ->limit($limit)
            ->get();
    }
}