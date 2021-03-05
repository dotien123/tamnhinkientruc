<?php


namespace App\Models;


class ProductVehicles extends BaseModel
{
    protected $table = 'products_vehicles';
    public $timestamps = false;

    public static function addVehiById($id, $cate) {
        if(!empty($cate)) {
            $insertData = [];
            foreach ($cate as $item) {
                $insertData[] = [
                    'p_id' => $id,
                    'v_id'  => $item,
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