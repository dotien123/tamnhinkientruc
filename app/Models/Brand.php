<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    const table_name = 'brand';
    protected $table = self::table_name;
    public $timestamps = false;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;
    protected static $cat = [];
    protected static $splitKey = '_';
    protected static $type = [
        '1' => 'Sản phẩm',
        '2' => 'Tin tức',
//        '3' => 'Videos',
//        '4' => 'Hình ảnh',
    ];

    protected $fillable = ['status', 'removed', 'id', 'alias', 'title', 'is_home', 'is_sidebar'];
    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public function type(){
        return isset(self::$type[$this->type]) ? self::$type[$this->type] : '1';
    }

    public function news(){
        return $this->belongsToMany(News::class, 'news_categories', 'cate_id', 'new_id');
    }

    public static function getBrand()
    {
        return self::where('status', 1)->select('id', 'image')->get();
    }
    
    public function product(){
        return $this->belongsToMany(Product::class, 'products_brand', 'brand_id', 'p_id');
    }

    public function brand_img(){
        return $this->hasMany(BrandImage::class, 'brand_id' , 'id');
    }

    public static function getNews4Cate(){
        $cate = self::with(['news' => function ($q) {
            $q->selectRaw('alias, title, image, published')->limit(8);
        }])->where('status', '>', '-1')->select('id','title')->get()->keyBy('id')->toArray();
        if($cate) {
            return $cate;
        }
        // dd($cat_id, $cate);
    }

    public function getImageUrl($size = 'medium'){
        return \ImageURL::getImageUrl($this->image, 'brand', $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'brand', $size);
    }

    public function getImageIconUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_icon, 'brand', $size);
    }

    public function link(){
        switch($this->type){
            case 1:
                return '';
            case 2:
                return '';
        }
        return '';
        //return route('product.list', ['safe_title' => str_slug($this->name), 'id' => $this->id]);
    }

    public static function getType(){
        return self::$type;
    }

    public static function getCateByID($id, $safe_title){
        $title = self::where([['id', $id], ['safe_title', $safe_title]])->value('title');
        if($title) {
            return $title;
        }
        return false;
    }
    public static function getCateByIDNew($id){
        $title = self::where('id', $id)->get()->toArray();
        if($title) {
            return $title;
        }
        return false;
    }

    static function getTreebrandCheckboxByType($type = 0, $selected) {
        $data = self::select('id', 'title', 'pid', 'type', 'status')->where([
            ['type', $type],
            ['status', BaseModel::STATUS_ACTIVE],
        ])->get()->toArray();
        
        $menu = self::buildTree($data, 0);
        if(empty($menu)) {
            $menu = $data;
        }
        $menu = self::buildTreeCateCheckbox($menu, $selected, ''); 
        return $menu;
    }

    static function buildTree($brand_data, $parent_id = 0, $selected = [], $loop = 0) {
        $data = [];
        foreach ($brand_data as $item) {
            if (isset($item['pid']) && $item['pid'] == $parent_id) {
                $children = self::buildTree($brand_data, $item['id']);
                if ($children) {
                    $item['children'] = $children;
                }
                $data[$item['id']] = $item;
                // unset($brand_data[$item['id']]);
            }
        }
        return $data;
    }

    static function buildTreeCateCheckbox($brand_data, $selected = [], $cate_pri = '' )
    {
        $html = "";
        if (isset($brand_data)) {
            foreach ($brand_data as $item) {
                if (empty($item['children'])) {

                    $html .=
                        '<fieldset><div class="checkbox mb-2">';

                    $html .= '<input class="radio" id="radio-'.$item['id'].'" ';
                    if ($selected && ($item['id'] === $selected)) {
                        $html .= ' checked="checked" ';
                    }

                    $html .= ' name="brand_id" value="'.$item['id'].'" type="radio">
                            <label for="radio-'.$item['id'].'">'.$item['title'].'</label>';
                        // if ($selected && ($item['id'] === $selected)) {
                        //     $html .= '<a href="javascript:void(0);" class="font-13 make '.(($item['id'] == $cate_pri) ? 'active' : '').' ml-2">Make primary</a>';
                        //     if($item['id'] == $cate_pri) {
                        //         $html .= '<input type="hidden" name="cate_primary" value="'.$item['id'].'" />';
                        //     }
                        // }
                    $html .= '</div></fieldset>';
                }
            }

        }
        return $html;
    }

}
