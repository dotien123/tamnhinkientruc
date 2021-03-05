<?php


namespace App\Models;


use App\Models\TagDetail;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class ServiceNew extends Model
{
    //
    const table_name = 'service';
    protected $table = self::table_name;
    public $timestamps = false;
    const KEY = 'servioe';
    const NUM_KEY = 1;
    const VIEWS = 0;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DRAFF = -2;
    const KEY_COOKIE_NEWS_HISTORY = 'COOKIE_HISTORY_NEW_';

    protected $fillable = ['status', 'removed', 'id', 'alias', 'title'];


    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image,  $size, 'service');
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo,  $size, 'service');
    }

    public function getLink(){
        return self::getLinkDetail($this->title_seo, $this->id);
    }
    
    public static function getServiceHome()
    {
        return self::where('status', 1)->select('title', 'alias', 'description', 'id', 'image')->take(3)->get();
    }
    
    public function category(){
        return $this->hasOne(Category::class, 'id', 'cate_primary');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'news_service', 'service_id', 'cate_id');
    }

    public static function getAllSeviceByCate($cat_id, $pagi = 10, $child = true){
        if($cat_id > 0) {
            $data = self::leftJoin('news_service', 'news_service.service_id', '=', 'service.id')
                ->where([
                    ['news_service.cate_id', $cat_id],
                    ['service.status', 1],
                ]);
            $data = $data->orderBy('service.published', 'desc')
            ->paginate($pagi);
            return $data;
        }
    }

    public static function getAlias($cate_id)
    {
        return self::leftJoin('news_service', 'news_service.service_id', '=', 'service.id')
        ->where('news_service.cate_id', $cate_id)->first();
    }

    public static function getAllServiceOnPage() {
        $wery = self::where('show_on_service_idx',1);

        return $wery->orderByRaw('sort_order, created')->get();
    }

}