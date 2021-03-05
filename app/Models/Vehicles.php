<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    //
    const table_name = 'vehicles';
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

    public static function getType(){
        return self::$type;
    }

    public function type(){
        return isset(self::$type[$this->type]) ? self::$type[$this->type] : '1';
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

    public static function getLiisVehicle()
    {
        return self::select('id', 'title', 'pid', 'type', 'status')->where('status', 1)->get();
    }

    static function getTreeVehiclesCheckboxByType($type = 0, $selected = [], $cate_pri) {
        $data = self::select('id', 'title', 'pid', 'type', 'status')->where([
            ['type', $type],
            ['status', BaseModel::STATUS_ACTIVE],
        ])->get()->toArray();

        $menu = self::buildTree($data, 0);
        if(empty($menu)) {
            $menu = $data;
        }
        $menu = self::buildTreeCateCheckbox($menu, $selected, $cate_pri = '');
        return $menu;
    }

    static function buildTree($menu_data, $parent_id = 0, $selected = [], $loop = 0) {
        $data = [];
        foreach ($menu_data as $item) {
            if (isset($item['pid']) && $item['pid'] == $parent_id) {
                $children = self::buildTree($menu_data, $item['id']);
                if ($children) {
                    $item['children'] = $children;
                }
                $data[$item['id']] = $item;
            }
        }
        return $data;
    }

    static function buildTreeCateCheckbox($menu_data, $selected = [], $cate_pri = '')
    {
        $html = "";
        if (isset($menu_data)) {
            foreach ($menu_data as $item) {
                if (empty($item['children'])) {
                    $html .=
                        '<fieldset><div class="checkbox mb-2">';

                    $html .= '<input class="" id="veh_id-'.$item['id'].'" ';
                        if ($selected && in_array($item['id'], $selected)) {
                            $html .= ' checked="checked" ';
                        }
                    $html .= ' name="veh_id[]" value="'.$item['id'].'" type="checkbox">
                            <label for="veh_id-'.$item['id'].'">'.$item['title'].'</label>';
                        // if ($selected && in_array($item['id'], $selected)) {
                        //     $html .= '<a href="javascript:void(0);" class="font-13 make '.(($item['id'] == $cate_pri) ? 'active' : '').' ml-2">Make primary</a>';
                        //     if($item['id'] == $cate_pri) {
                        //         $html .= '<input type="hidden" name="cate_primary" value="'.$item['id'].'" />';
                        //     }
                        // }
                    $html .= '</div></fieldset>';
                }

                // if (!empty($item['children'])) {
                //     $html .= '<fieldset><div class="checkbox mb-2">';
                //     $html .= '<input class="" id="checkbox-'.$item['id'].'" ';
                //     if ($selected && in_array($item['id'], $selected)) {
                //         $html .= ' checked="checked" ';
                //     }
                //     $html .=  'name="veh_id[]" value="'.$item['id'].'" type="checkbox">
                //                 <label for="veh_id-'.$item['id'].'">'.$item['title'].'</label>';
                //     if ($selected && in_array($item['id'], $selected)) {
                //         $html .= '<a href="javascript:void(0);" class="font-13 make '.(($item['id'] == $cate_pri) ? 'active' : '').' ml-2">Make primary</a>';
                //         if($item['id'] == $cate_pri) {
                //             $html .= '<input type="hidden" name="cate_primary" value="'.$item['id'].'" />';
                //         }
                //     }
                //     $html .= '</div>
                //             <div class="dd-list ml-3">';
                //     $html .= self::buildTreeCateCheckbox($item['children'], $selected, $cate_pri);
                //     $html .= '</div></fieldset>';
                // }
            }

        }
        return $html;
    }


}
