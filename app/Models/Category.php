<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Category extends Model
{
    //
    const table_name = 'categories';
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
        // '2' => 'Tin tức',
        // '3' => 'Dịch vụ',
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
    
    public function product(){
        return $this->belongsToMany(Product::class, 'products_categories', 'cate_id', 'p_id');
    }

    public function category_img(){
        return $this->hasMany(CategoryImage::class, 'cat_id' , 'id');
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
        return \ImageURL::getImageUrl($this->image, 'category', $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'category', $size);
    }

    public function getImageIconUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_icon, 'category', $size);
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

    public static function getProduct($cate_id)
    {
        $id_product = DB::table('products_categories')->where('cate_id', $cate_id)->get();
        if($id_product != [])
        {
            foreach($id_product as $v)
            {
                $id[] = $v->p_id;
            }
            if(!empty($id))
            {
                $product = Product::whereIn('id', $id)->where('status', 1)->get();
                return $product;
            }        
        }
        
        return false;
       

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

    public static function getPureCate($type = 1)
    {
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }

        $sql = [];
        if ($type > 0) {
            $sql[] = ['type', '=', $type];
        }
        $sql[] = ['lang', '=', $lang];
        $sql[] = ['status', '>', 0];

        $data = self::where($sql)
            ->orderByRaw('type, pid, sort ASC, title')
            ->get()
            ->keyBy('id');

        return $data;
    }

    public static function getCat($type = 0, $lang = '', $imgSize = ''){
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $key = $type . '-' . $lang;
        if(empty(self::$cat[$key])) {

            $sql = [];
            if ($type > 0) {
                $sql[] = ['type', '=', $type];
            }
            $sql[] = ['lang', '=', $lang];
            $sql[] = ['status', '>', 0];
            $sql[] = ['is_home',  0];

            $data = self::with('category_img')->where($sql)
                ->orderByRaw('type, pid, sort DESC, title')
                ->get()
                ->keyBy('id');
            $cat = [];
            if ($type <= 0) {
                foreach ($data as $k => $v) {
                    if(isset(self::$type[$v->type])) {
                        if (!isset($cat[$v->type])) {
                            $cat[$v->type] = [
                                'title' => self::$type[$v->type],
                                'type' => $v->type,
                                'cats' => []
                            ];
                        }
                        $cat[$v->type]['cats'][$v->id] = $v;
                    }
                }
                foreach ($cat as $k => $v){
                    $cat[$k]['cats'] = self::fetchAll($v['cats'], $imgSize);
                }
            } else {
                $cat = self::fetchAll($data, $imgSize);

            }
            self::$cat[$key] = $cat;
        }
        return self::$cat[$key];
    }

    public static function getCateNews()
    {
       return self::where([['status', 1], ['type', 2], ['is_home', 3]])->get();
    }
    public static function getCatMenu($type = 0, $lang = '', $imgSize = ''){
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $key = $type . '-' . $lang;
        if(empty(self::$cat[$key])) {

            $sql = [];
            if ($type > 0) {
                $sql[] = ['type', '=', $type];
            }
            $sql[] = ['lang', '=', $lang];
            $sql[] = ['status', '>', 0];

            $data = self::with('category_img')->where($sql)
                ->orderByRaw('type, pid, sort DESC, title')
                ->get()
                ->keyBy('id');
            $cat = [];
            if ($type <= 0) {
                foreach ($data as $k => $v) {
                    if(isset(self::$type[$v->type])) {
                        if (!isset($cat[$v->type])) {
                            $cat[$v->type] = [
                                'title' => self::$type[$v->type],
                                'type' => $v->type,
                                'cats' => []
                            ];
                        }
                        $cat[$v->type]['cats'][$v->id] = $v;
                    }
                }
                foreach ($cat as $k => $v){
                    $cat[$k]['cats'] = self::fetchAll($v['cats'], $imgSize);
                }
            } else {
                $cat = self::fetchAll($data, $imgSize);

            }
            self::$cat[$key] = $cat;
            $newtitle=[];
            foreach (self::$cat[$key] as $k => $value) {
                $newtitle[$k]=explode(' ',$value['title']);
            }
            foreach ($newtitle as $key => $value) {
                foreach ($value as $k => $v) {
                    $pos = strpos($v, 'gr');
                    if($pos == true){
                        $newtitle[$key][$k] = '<span>'.$v.'</span>' ;
                    }
                }
                
            }
            foreach ($newtitle as $key => $value) {
                $newtitle[$key]=join(" ",$value);
            }
            
            foreach ($cat as $key => $value) {
                $cat[$key]['title']= $newtitle[$key];
            }
            self::$cat[$key] = $cat;
        }
     
        return self::$cat[$key];
    }

    static function getTreeCateCheckboxByType($type = 0, $selected = [], $cate_pri) {
        $data = self::select('id', 'title', 'pid', 'type', 'status')->where([
            ['type', $type],
            ['status', BaseModel::STATUS_ACTIVE],
        ])->get()->toArray();
        $menu = self::buildTree($data, 0);
        if(empty($menu)) {
            $menu = $data;
        }
        $menu = self::buildTreeCateCheckbox($menu, $selected, $cate_pri);
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
                // unset($menu_data[$item['id']]);
            }
        }
        return $data;
    }

    static function buildTreeCateCheckbox($menu_data, $selected = [], $cate_pri)
    {
        $html = "";
        if (isset($menu_data)) {
            foreach ($menu_data as $item) {
                if (empty($item['children'])) {
                    $html .=
                        '<fieldset><div class="checkbox mb-2">';

                    $html .= '<input class="cker" id="checkbox-'.$item['id'].'" ';
                        if ($selected && in_array($item['id'], $selected)) {
                            $html .= ' checked="checked" ';
                        }
                    $html .= ' name="cate_ids[]" value="'.$item['id'].'" type="checkbox">
                            <label for="checkbox-'.$item['id'].'">'.$item['title'].'</label>';
                        if ($selected && in_array($item['id'], $selected)) {
                            $html .= '<a href="javascript:void(0);" class="font-13 make '.(($item['id'] == $cate_pri) ? 'active' : '').' ml-2">Make primary</a>';
                            if($item['id'] == $cate_pri) {
                                $html .= '<input type="hidden" name="cate_primary" value="'.$item['id'].'" />';
                            }
                        }
                    $html .= '</div></fieldset>';
                }

                if (!empty($item['children'])) {
                    $html .= '<fieldset><div class="checkbox mb-2">';
                    $html .= '<input class="cker" id="checkbox-'.$item['id'].'" ';
                    if ($selected && in_array($item['id'], $selected)) {
                        $html .= ' checked="checked" ';
                    }
                    $html .=  'name="cate_ids[]" value="'.$item['id'].'" type="checkbox">
                                <label for="checkbox-'.$item['id'].'">'.$item['title'].'</label>';
                    if ($selected && in_array($item['id'], $selected)) {
                        $html .= '<a href="javascript:void(0);" class="font-13 make '.(($item['id'] == $cate_pri) ? 'active' : '').' ml-2">Make primary</a>';
                        if($item['id'] == $cate_pri) {
                            $html .= '<input type="hidden" name="cate_primary" value="'.$item['id'].'" />';
                        }
                    }
                    $html .= '</div>
                            <div class="dd-list ml-3">';
                    $html .= self::buildTreeCateCheckbox($item['children'], $selected, $cate_pri);
                    $html .= '</div></fieldset>';
                }
            }

        }
        return $html;
    }

    public static function fetchAll($data, $imgSize = ''){
        $cat = [];
        foreach ($data as $k => $v) {
            if ($v->pid == 0) {
                $cat[self::$splitKey.$v->id] = self::fetchCat($v, $imgSize);
                unset($data[$k]);
            } elseif (isset($cat[self::$splitKey.$v->pid])) {
                $cat[self::$splitKey.$v->pid]['sub'][self::$splitKey.$v->id] = self::fetchCat($v,$imgSize);
                unset($data[$k]);
            }
        }
        foreach ($data as $v) {
            foreach ($cat as $pid => $item){
                foreach ($item['sub'] as $id => $sub){
                    if(self::$splitKey.$v->pid == $id){
                        $cat[$pid]['sub'][$id]['sub'][self::$splitKey.$v->id] = self::fetchCat($v,$imgSize);
                    }
                }
            }
        }
        return $cat;
    }

    public static function fetchCat($cat, $imgSize = ''){
        $out = $cat->toArray();
        $out['image'] = $cat->getImageUrl($imgSize);
        $out['link'] = $cat->link();
        $out['sub'] = [];
        return $out;
    }

    static function init_category($id = false) {
        $arrtitle = ['Thiết bị thể thao & thể hình', 'Hoạt động dã ngoại', 'Giày thể thao', 'Thể thao dưới nước', 'Dao & dụng cụ đa năng'];
        $title = $arrtitle[$id-1];
        $basicInfo = [
            'title' => $title,
            'id' => $id,
            'safe_title' => str_slug($title),
            'type' => 1,
            'created' => time()
        ];
        
        self::insert($basicInfo);
    }

    static function getDanhSachIdHienThiSideBar() {
        $ids = self::where([
            ['type', 1],
            ['is_sidebar', 1],
        ])->select('id')->pluck('id')->toArray();
        return $ids;
    }
    static function getDanhSachIdHienThiTrangChu() {
        $ids = self::where([
            ['type', 1],
            ['is_home', 1],
        ])->select('id')->pluck('id')->toArray();
        return $ids;
    }
}
