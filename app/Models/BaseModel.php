<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    protected $table = '';

    protected $fillable = [];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -1;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;

    public function getImageUrl($field = 'image', $table, $size = 'medium'){
        return \ImageURL::getImageUrl($this->$field, $table, $size);
    }

    static function getDbTable($table)
    {
        return DB::table($table);
    }
}