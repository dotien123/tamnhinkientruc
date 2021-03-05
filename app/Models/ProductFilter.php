<?php

namespace App\Models;

use App\Models\TagDetail;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class ProductFilter extends Model
{
    //
    protected $table = 'product_filters';
    public $timestamps = false;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function color(){
        return $this->hasOne(ColorSize::class, 'id', 'filter_id')->where('type', ColorSize::COLOR_TYPE);
    }
    public function size(){
        return $this->hasOne(ColorSize::class, 'id', 'filter_id')->where('type', ColorSize::SIZE_TYPE);
    }

    public function images(){
        return $this->hasMany(ProductFilterImage::class, 'filter_id', 'id');
    }

}

