<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideosCate extends Model
{
    //
    protected $table = 'videos_categories';
    public $timestamps = false;


    public static function addCateById($id, $cate, $cate_par, $type = 1) {
        if(!empty($cate)) {
            $insertData = [];
            foreach ($cate as $item) {
                $insertData[] = [
                    'videos_id' => $id,
                    'cate_par'  => $cate_par,
                    'cate_id'  => $item,
                ];
            }

            if (!empty($insertData)) {
                //xoa het content cu
                self::where('videos_id', $id)
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
