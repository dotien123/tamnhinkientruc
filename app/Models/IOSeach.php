<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class IOSeach extends Model
{
    protected $table = 'io_search';
    public $timestamps = false;

    public function category(){
        return $this->hasOne(Category::class, 'id', 'cate_id');
    }

    static function searchByTable($cond = [], $key = '') {
        $per = 20;
        if($key == '' && empty($cond)) {
            return self::paginate($per);
        }
        if(empty($cond)) {
            return self::where('keyword','LIKE','%'.$key.'%')->paginate($per);
        }
        return self::where($cond)->where('keyword','LIKE','%'.$key.'%')->paginate($per);
    }
}