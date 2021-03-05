<?php


namespace App\Models;


class ProductCate extends BaseModel
{
    protected $table = 'products_categories';
    public $timestamps = false;

    public static function addCateById($id, $cate) {
        if(!empty($cate)) {
            $insertData = [];
            foreach ($cate as $item) {
                $insertData[] = [
                    'p_id' => $id,
                    'cate_id'  => $item,
                ];
            }

            if (!empty($insertData)) {
                //xoa het content cu
                self::where('p_id', $id)
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