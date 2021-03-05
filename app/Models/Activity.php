<?php

namespace App\Models;

use App\Models\TagDetail;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class Activity extends Model
{
    //
    const table_name = 'activity';
    protected $table = self::table_name;
    public $timestamps = false;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;


    protected $fillable = ['title', 'removed', 'status', 'created', 'link'];
    

    public function getImageUrl($k = 'image', $size = 'original'){
        return \ImageURL::getImageUrl($this->$k, $this->table, $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, $this->table, $size);
    }

    public function getLink(){
        return self::getLinkDetail($this->title_seo, $this->id);
    }


}

