<?php


namespace App\Models;

class Unit extends BaseModel
{
    //
    const table_name = 'unit';
    protected $table = self::table_name;
    public $timestamps = false;

    public static function getUnitList($selected = FALSE, $status = FALSE) {
        $listStatus = Unit::where('status', BaseModel::STATUS_ACTIVE)->get()->toArray();
        if ($selected && isset($listStatus[$selected])) {
            $listStatus[$selected]['checked'] = 'checked';
        }elseif($status !== FALSE) {
            if(isset($listStatus[$status])) {
                return $listStatus[$status];
            }
            return false;
        }
        return $listStatus;
    }

}