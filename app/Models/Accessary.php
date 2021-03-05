<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessary extends Model
{
    //
    const table_name = 'accescary';
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
    ];
   
    protected $fillable = ['status', 'removed', 'id', 'alias', 'title', 'is_home', 'is_sidebar'];
    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public static function getCat()
    {
        return self::where([['status', 1], ['is_home', 1]])->get();
    }

    public function getImageUrl($size = 'medium'){
        return \ImageURL::getImageUrl($this->image, 'accescary', $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'accescary', $size);
    }

    public function getImageIconUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_icon, 'accescary', $size);
    }

    public function type(){
        return isset(self::$type[$this->type]) ? self::$type[$this->type] : '1';
    }

    static function getTreeStatusCheckboxByType($type = 0, $selected) {
        $data = self::select('id', 'title', 'pid', 'type', 'status')->where([
            ['type', $type],
            ['status', BaseModel::STATUS_ACTIVE],
        ])->get()->toArray();
        
        $menu = self::buildTree($data, 0);
        if(empty($menu)) {
            $menu = $data;
        }
        $menu = self::buildTreeStatusCheckbox($menu, $selected, ''); 
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
            }
        }
        return $data;
    }

    static function buildTreeStatusCheckbox($brand_data, $selected = [], $cate_pri = '' )
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
                    $html .= '</div></fieldset>';
                }
            }

        }
        return $html;
    }

}
