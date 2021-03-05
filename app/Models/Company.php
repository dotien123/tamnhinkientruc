<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $table = 'company';
    public $timestamps = false;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $fillable = ['title', 'removed', 'status', 'created'];

    public function getImageUrl($k = 'image', $size = 'original'){
        return \ImageURL::getImageUrl($this->$k, 'company', $size);
    }
}