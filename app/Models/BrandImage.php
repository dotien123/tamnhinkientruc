<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class BrandImage extends Model
{
    protected $table = 'brand_img';
    public $timestamps = false;
    const TYPE = [
        1 => 'product',
        2 => 'news',
    ];
    public function brand(){
        return $this->hasOne(brand::class , 'id' ,'brand_id');
    }

    //insert cat_image
    public static function addImages($image , $id ){
        if(isset($image)){
            $inSeinsertData = [];
            foreach ($image as $key => $value){
                $inSeinsertData[] = [
                    'image' => $value,
                    'brand_id' => $id,
                    'created' => time(),
                    'type' => self::TYPE[$type],
                ];
            }
            BrandImage::insert($inSeinsertData);
        }
    }
}