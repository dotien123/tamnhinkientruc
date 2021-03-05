<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ColorSize extends Model
{
    protected $table = 'colors_sizes';
    public $timestamps = false;
    const SIZE_TYPE = 'size';
    const COLOR_TYPE = 'color';
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $fillable = ['title', 'removed', 'status', 'created', 'type', 'hex'];

    public static function getColorSize($type = 'color') {
        return self::where([
            ['type', $type],
            ['status', self::STATUS_ACTIVE],
        ])->get()->keyBy('id')->toArray();
    }

}