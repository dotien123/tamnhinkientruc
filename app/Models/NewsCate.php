<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCate extends BaseModel
{
    //
    protected $table = 'news_categories';
    public $timestamps = false;


    public static function addCateById($id, $cate) {
        if(!empty($cate)) {
            $insertData = [];
            foreach ($cate as $item) {
                $insertData[] = [
                    'new_id' => $id,
                    'cate_id'  => $item,
                ];
            }

            if (!empty($insertData)) {
                //xoa het content cu
                self::where('new_id', $id)
                    ->delete();
                //chen moi
                // dd($insertData);
                self::insert($insertData);
                return true;
            }
        }
        return false;
    }
}
