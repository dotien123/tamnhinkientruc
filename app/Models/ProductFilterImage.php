<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductFilterImage extends Model
{
    protected $table = 'product_filters_images';
    public $timestamps = false;

    protected $fillable = ['basic_pid', 'filter_id'];

    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->title, 'product', $size);
    }

    public function setLinkImageAttribute($value)
    {
        $this->original['link'] = strtolower($value);
        return $this;
    }



}