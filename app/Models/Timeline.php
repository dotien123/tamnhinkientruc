<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $table = 'timeline';
    public $timestamps = false;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image, 'timeline', $size);
    }

    static function getAllTimeLine($order = []) {
        return self::where('status', self::STATUS_ACTIVE)->select('id', 'title', 'image', 'status')->orderByRaw($order)->get();
    }

    static function __init__timeline($id) {
        $title = ['2005 - 2008', '2008 - 2012', '2012 - 2015', '2015 - 2020'];
        return self::insert([
            'id' => $id,
            'title' => $title[array_rand($title)],
            'image' => 'azienda-'.rand(1, 5).'_highlight_gallery.jpg',
            'created' => time(),
            'status' => self::STATUS_ACTIVE,
            'description' => 'Pavis là một tổ chức rất tích hợp, bắt đầu với nghiên cứu và phát triển, dệt, hoàn thiện và cuối cùng là tiếp thị và quan trọng là dịch vụ khách hàng. Chất liệu cotton sang trọng, các loại vải không gây dị ứng tiếp xúc với da, chức năng, hiệu quả và sự thoải mái là tất cả những thế mạnh được tạo ra từ nghiên cứu, phát triển và sản xuất, với mục tiêu duy nhất: bệnh nhân khỏe mạnh và phong cách sống tốt nhất.',
        ]);
    }
}