<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GeoProvince extends Model
{
    //
    protected $table = '_geovnprovince';
    protected $fillable = ['id' ,'Name_VI' ,'code' ,'safe_title' ];
    public $timestamps = false;

    public static function getAll() {
        return self::orderBy('safe_title')->get();
    }

    public static function getAllIfHasWarehouse() {
        $wery = Warehouse::where('province_id','>',0);
        $wery->select(DB::raw('DISTINCT province_id'));

        $province_support = $wery->get()->keyBy('province_id')->toArray();
        if(!empty($province_support)) {
            return self::whereIn('id',array_keys($province_support))->orderBy('safe_title')->get();
        }
        return false;
    }

    public static function getListProvinces(){
        $cities =  self::orderBy('safe_title')->get()->keyBy('id')->all();
        $data = [];
        foreach($cities as $k=>$r){
            $data[$r->id] = $r->Name_VI;
        }
        return $data;
    }

    public function warehouses(){
        return $this->hasMany(Warehouse::class, 'province_id', 'id');
    }

    public function districts(){
        return $this->hasMany(GeoDistrict::class, 'Province_ID');
    }

    public static function getProvince(){
        $wery = \DB::table('_geovnprovince')
            ->leftJoin('warehouse','warehouse.province_id', '=', '_geovnprovince.id')
            ->where('warehouse.status', '>', 1)
            ->first();
        return $wery;
    }

    public static function getWarehouseByProvince(){
        $wery = self::with(['warehouses' => function($q){
           $q->where('status', '>', 1);
        }])
//            ->leftJoin('_geovnprovince', '_geovnprovince.id', '=', 'warehouse.province_id')
//            ->select('Name_VI')
////            ->where('warehouse.status', '>', 1)
            ->get();
//            ->keyBy('Name_VI');
        dd($wery);
        return $wery;
    }


}



