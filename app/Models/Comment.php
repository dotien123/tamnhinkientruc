<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Comment extends Model {


    protected $table = 'comments';
    protected $fillable = ['id', 'uid', 'type', 'type_id', 'comment','aid', 'rep_comment', 'status'];
    public $timestamps = false;
    const TYPEPRODUCT = '1';    // 1: product
    protected $types = [
        'page_static' => 'Trang Tĩnh'
    ];

    public static function getUername($id)
    {
        return User::where('id', $id)->first()->fullname;
    }

    public static function getnameComment($name)
    {
        $text = '';

        switch ($name) {
            case 'news':
                $text = 'Tin tức';
            break;
            
            case 'products':
                $text = 'Sản phẩm';
            break;

            case 'contact':
                $text = 'Liên Hệ';
            break;

            case 'videos':
                $text = 'videos';
            break;

            case 'tuvan':
                $text = 'Tư vấn';
            break;

            case 'page_intro':
                $text = 'Giới thiệu';
            break;

            case 'service':
                $text = 'Dịch vụ';
            break;

            case 'page_static':
                $text = 'Trang tĩnh';
            break;

            default:
                $data = 'Sản phẩm';
        }
        return $text;

    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'uid', 'id');
    }

    public static function getComment($id, $table_name)
    {
        return Comment::where([['type_id', $id], ['tableName', $table_name], ['comment_parent', 0], ['status', 1] ])->paginate(5);
    }

    public function parent()
    {
        return $this->hasOne(Comment::class,'id','comment_parent');
    }

    public function getcommentrep($id, $table)
    {
        return Comment::where([['id', $id], ['tableName', $table]])->first();
    }

    public static function getcommentChil($id_prod = '', $table, $id_cmt, $status = '1')
    {
        return Comment::where([['type_id', $id_prod], ['tableName', $table], ['comment_parent', $id_cmt], ['status', $status] ])->get();
    }

    public function product(){
        return $this->belongsTo(Product::class, 'type_id', 'id');
    }

    public function news(){
        return $this->belongsTo(News::class, 'type_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'aid', 'id');
    }

    public static function getCommentProductById($id) {
        return self::where([['status', 1], ['type_id', $id], ['type', self::TYPEPRODUCT]]);
    }

    public static function getAllCommentProductById($id) {
        return self::where([['status', 1], ['type_id', $id], ['type', self::TYPEPRODUCT]]);
    }
    
    public static function getSumRate($id) {
        return self::select('rating')
                ->where([['status', 1], ['type_id', $id], ['type', self::TYPEPRODUCT]])
                ->sum('rating');
        ;
    }

    public static function getCountRate($id) {
        return self::select('rating')
                ->where([['status', 1], ['type_id', $id], ['aid', ''], ['type', self::TYPEPRODUCT]])
                ->count('rating');
        ;
    }
}