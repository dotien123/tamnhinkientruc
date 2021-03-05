<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Tag;
use App\Models\TagDetail;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class Linen extends Model
{
    //
    protected $table = 'linen';
    public $timestamps = false;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const KEY_COOKIE_NEWS_HISTORY = 'COOKIE_HISTORY_NEW_';

    protected $fillable = ['title', 'removed', 'status', 'created', 'alias'];

    public function categories(){
        return $this->belongsToMany(Category::class, 'news_categories', 'new_id', 'cate_id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'cate_par');
    }

    public function authors(){
        return $this->hasOne('App\Models\User', 'id', 'author');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'tag_details', 'object_id', 'tag_id');
    }


    static function getFabricWithPerPage($per = 20, $order)
    {
        return self::where('status', self::STATUS_ACTIVE)->orderByRaw($order)->paginate($per);
    }

    static function get4FabricLatest($limit = 20, $order)
    {
        return self::where('status', self::STATUS_ACTIVE)->where('in_home', 1)->orderByRaw($order)->select('id', 'description', 'image', 'title', 'alias', 'status')->get();
    }


    public function getImageUrl($k = 'image', $size = 'original'){
        return \ImageURL::getImageUrl($this->$k, 'linen', $size);
    }

    public function getLink(){
        return self::getLinkDetail($this->title_seo, $this->id);
    }

    static function __init_fabric($id) {
        self::insert([
            'id' => $id,
            'title' => '# Vải nano '. rand(1, 50),
            'description' => 'L’innovativo tessuto TWO FEEL è un esclusivo tessuto a DOPPIO STRATO creato da PAVIS che garantisce il comfort del cotone 100% sulla pelle, massima traspirazione, unitamente ad una perfetta vestibilità.',
            'created' => time(),
            'image' => '',
            'alias' => str_slug('vai-nano-'.rand(50, 100).'-'. uniqid()),
        ]);
    }
}

