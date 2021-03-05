<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\ImageURL;
use App\Models\GeoDistrict;
use App\Models\StoreImage;

class Stores extends Model
{
    protected $table = 'stores';
    public $timestamps = false;
    protected $fillable = ['status', 'id', 'name_store', 'address' , 'link_map' , 'link_map_ifame' , 'image' , 'phone' , 'description'];
    const STATUS_ACTIVE = 2;
    const STATUS_INACTIVE = 0;
    const STATUS_DETELE = -1;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    const KEY = 'stores';
    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public function district()
    {
        return $this->belongsTo(GeoDistrict::class, 'district_id', 'id');
    }

    public function getImageUrl($size = 'original')
    {
        return !empty($this->image) ? ImageURL::getImageUrl($this->image, self::KEY, $size) : '';
    }

    public static function getLatLng($order = []){
        $data = self::where('status', '>' , 1)
            ->orderBy('name_store')
            ->whereNotNull('lat')
            ->whereNotNull('long');

        if(!empty($order)){
            $data = $data->where($order)->select('id' , 'name_store' , 'address' , 'lat' , 'long' , 'image' )->get();
        }else{
            $data = $data->select('id' , 'name_store' , 'address' , 'lat' , 'long' , 'image')->get();
        }
        return json_encode($data);
    }
    public static function getImageGallery($hotel_id = 0,$type="hotel", $json = false){
        $images = StoreImage::where('type',$type)->where('object_id', $hotel_id)->orderByRaw('sort desc,created desc')->get();
        $data = [];
        foreach($images as $image){
            $tmp = $image->toArray();
            $tmp['img'] = $image->image;
            $tmp['image_sm'] = $image->getImageUrl('image', 'stores', 'medium');
            $tmp['image_md'] = $image->getImageUrl('image', 'stores', 'medium');
            $tmp['image'] = $image->getImageUrl('image', 'stores', 'large');
            $tmp['image_org'] = $image->getImageUrl();
            array_push($data, $tmp);
        }
        return $json ? json_encode($data) : $data;
    }
}