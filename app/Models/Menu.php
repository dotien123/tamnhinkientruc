<?php

namespace App\Models;

use App\Models\Category;
use App\Models\News;
use App\Models\PageIntro;
use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
class Menu extends Model
{
    //
    protected $table = 'menu';
    public $timestamps = false;
    protected static $splitKey = '_';
    public static $menuType = [
        0 => 'Admin Botom Menu',
        1 => 'Admin Top Menu',
        // 2 => 'Admin Bottom Menu',
        3 => 'Public Header Menu',
        4 => 'Public Footer Menu',
        5 => 'Mobile Menu',
        9 => 'Khác'
    ];

    public static $menuOid = [
        1 => [
            'title' => 'Danh mục sản phẩm',
            'table' => Category::table_name,
            'type' => 1,
        ],
        2 => [
            'title' => 'Danh mục bài viết',
            'table' => Category::table_name,
            'type' => 2,
        ],
        3 => [
            'title' => 'Bài viết',
            'table' => News::table_name,
        ],
        4 => [
            'title' => 'Bài viết giới thiệu',
            'table' => PageIntro::table_name,
        ],
        5 => [
            'title' =>'Bài viết trang tĩnh',
            'table' => Page::table_name,
        ]
    ];

    protected $fillable = ['status', 'removed', 'id', 'title'];
    protected static $menu = [];
    const DEF_MENU_KEY = '99999999999';

    public function lang(){
        $lang = config('app.locales');
        return isset($lang[$this->lang]) ? $lang[$this->lang] : 'vi';
    }

    public function type(){
        return self::$menuType[$this->type];
    }

    public function getLink(){
        $def = '#';
        if(!empty($this->link)) {
            if(\Lib::isUrl($this->link)){
                return $this->link;
            }
            return \Route::has($this->link) ? route($this->link) : $def.$this->link;
        }elseif(isset(self::$menuOid[$this->type_obj]) && $this->oid > 0) {
            $typeObj = (self::$menuOid[$this->type_obj]);
            if($typeObj['table'] == Category::table_name) {
                $lsObj = \DB::table(Category::table_name)->select('id', 'alias', 'status')->where('type', $typeObj['type'])->find($this->oid);
                return route('news.cate', ['alias' => $lsObj->alias, 'id' => $lsObj->id]);
            }elseif ($typeObj['table'] == News::table_name) {
                $lsObj = \DB::table(News::table_name)->select('id', 'alias')->find($this->oid);
                return route('news.detail', ['alias' => $lsObj->alias]);
            }elseif ($typeObj['table'] == PageIntro::table_name) {
                $lsObj = \DB::table(PageIntro::table_name)->select('id', 'alias')->find($this->oid);
                return route('introduce.detail', ['alias' => $lsObj->alias]);
            }elseif ($typeObj['table'] == Page::table_name) {
                // $lsObj = \DB::table(Page::table_name)->select('id', 'alias')->find($this->oid);
                // return route('page.index', ['alias' => $lsObj->alias]);
            }
        }
        return $def;
    }

    public static function getMenu($type = 0, $sys_menu_ok = false, $lang = ''){
        if(empty($lang)){
            $lang = \Lib::getDefaultLang();
        }
        $key = $type . '-' . $lang;
        if(empty(self::$menu[$key])) {
            $sql = [];
            if ($type >= 0) {
                $sql[] = ['type', '=', $type];
            }
            $sql[] = ['lang', '=', $lang];
            $sql[] = ['status', '>', 0];

            $data = self::where($sql)
                ->orderByRaw('type, pid, sort ASC, title')
                ->get()
                ->keyBy('id');
            $menu = [];
            if ($type < 0) {
                foreach ($data as $k => $v) {
                    if (!isset($menu[$v->type])) {
                        $menu[$v->type] = [
                            'title' => self::$menuType[$v->type],
                            'type' => $v->type,
                            'menu' => []
                        ];
                    }
                    $menu[$v->type]['menu'][$v->id] = $v;
                }
                foreach ($menu as $k => $v){
                    $menu[$k]['menu'] = self::fetchAll($v['menu'], $sys_menu_ok && ($type == 0));
                }
            } else {
                $menu = self::fetchAll($data, $sys_menu_ok && ($type == 0));
            }
            self::$menu[$key] = $menu;
        }
        return self::$menu[$key];
    }

    public static function fetchAll($data, $sys_menu = false){
        $menu = [];
        foreach ($data as $k => $v) {
            if ($v->pid == 0) {
                $menu[self::$splitKey.$v->id] = self::fetchMenu($v);
                unset($data[$k]);
            } elseif (isset($menu[self::$splitKey.$v->pid])) {
                $menu[self::$splitKey.$v->pid]['sub'][self::$splitKey.$v->id] = self::fetchMenu($v);
                unset($data[$k]);
            }
        }
        foreach ($data as $v) {
            foreach ($menu as $pid => $item){
                foreach ($item['sub'] as $id => $sub){
                    if(self::$splitKey.$v->pid == $id){
                        $menu[$pid]['sub'][$id]['sub'][self::$splitKey.$v->id] = self::fetchMenu($v);
                    }
                }
            }
        }
        if($sys_menu){
            $menu[self::$splitKey.self::DEF_MENU_KEY] = self::defAdminMenu();
        }
        return $menu;
    }

    public static function fetchMenu($menu){
        $out = [
            'id' => $menu->id,
            'title' => $menu->title,
            'alias' => $menu->alias,
            'description' => !empty($menu->description) ? $menu->description : '',
            'keywords' => !empty($menu->keywords) ? $menu->keywords : '',
            'title_seo' => !empty($menu->title_seo) ? $menu->title_seo : '',
            'link' => $menu->getLink(),
            'perm' => !empty($menu->perm) ? $menu->perm : '',
            'no_follow' => !empty($menu->no_follow) ? $menu->no_follow : 1,
            'newtab' => !empty($menu->newtab) ? $menu->newtab : 0,
            'icon' => !empty($menu->icon) ? $menu->icon : '',
            'oid' => !empty($menu->oid) ? $menu->oid : '',
            'type_obj' => !empty($menu->type_obj) ? $menu->type_obj : '',
            'active' => !empty($menu->active) ? $menu->active : '',
            'sub' => []
        ];
        return $out;
    }

    protected static function defAdminMenu(){
        $menu = self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY,
            'title' => 'Cấu hình hệ thống',
            'perm' => ''
        ]));
        array_push($menu['sub'], self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY+4,
            'title' => 'Cấu hình',
            'icon' => 'bx bx-cog bx white',
            'perm' => 'config-change',
            'link' => 'admin.config',
        ])));
        array_push($menu['sub'], self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY+1,
            'title' => 'Menu',
            'icon' => 'bx-menu-alt-left',
            'perm' => 'menu-view',
            'link' => 'admin.menu'
        ])));

        array_push($menu['sub'], self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY+2,
            'title' => 'Người dùng',
            'icon' => 'bx-group',
            'perm' => 'user-view',
            'link' => 'admin.user',
        ])));

        array_push($menu['sub'], self::fetchMenu(self::createDefaultMenu([
            'id' => self::DEF_MENU_KEY+3,
            'title' => 'Phân quyền',
            'icon' => 'bxs-flag-alt',
            'perm' => 'role-view',
            'link' => 'admin.role',
        ])));


        return $menu;
    }

    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image, 'menu', $size);
    }

    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'menu', $size);
    }

    protected static function createDefaultMenu($menu){
        $a = new Menu();
        foreach ($menu as $k => $v){
            $a->$k = $v;
        }
        return $a;
    }
}
