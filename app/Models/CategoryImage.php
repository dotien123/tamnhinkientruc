<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class CategoryImage extends Model
{
    protected $table = 'category_img';
    public $timestamps = false;
    const TYPE = [
        1 => 'product',
        2 => 'news',
    ];
    public function category(){
        return $this->hasOne(Category::class , 'id' ,'cat_id');
    }

    //insert cat_image
    public static function addImages($image , $id , $type){
        if(isset($image)){
            $inSeinsertData = [];
            foreach ($image as $key => $value){
                $inSeinsertData[] = [
                    'image' => $value,
                    'cat_id' => $id,
                    'created' => time(),
                    'type' => self::TYPE[$type],
                ];
            }
            CategoryImage::insert($inSeinsertData);
        }
    }
}