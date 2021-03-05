<?php


namespace App\Modules\FrontEnd\Controllers;


use App\Http\Controllers\Controller;
use App\Models\ConfigSite;
use App\Models\Feature;
use App\Models\Menu;
use App\Models\Comment;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request, $id){
        if(isset($id)){
            $banner=Feature::getSlides($id);
        }else{
            $banner=[];
        }
        $seo_menu = Menu::where('link', 'introduce.index')->first();

        $seo_title = @$seo_menu['title_seo'] ? $seo_menu['title'] : 'Liên hệ';
        $seo_des = @$seo_menu['description_seo'] ? @$seo_menu['description_seo']  : 'Liên hệ';
        $seo_keyword = @$seo_menu['keywords']? $seo_menu['title'] : 'Liên hệ';
        $seo_robots = \Lib::robotSEO(@$seo_menu['robots']) ? '': '';
        $seo_image = @$seo_menu['image_seo'];
        $seo_url_image = '';
        #endregion
        ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);
        $table_name = 'contact';
        $cmt = Comment::getComment(0, $table_name);

        return view('FrontEnd::pages.contact.index', [
            'cmt' => $cmt,
            'tableName' =>  $table_name,
            'active' => $id,
            'site_title' => 'LIÊN HỆ VÀ ĐẶT HÀNG',
            'site_title_mini1' => 'Liên hệ',
            'banner' => $banner
        ]);
    }

    
    public function sale()
    {
        $alias = 'mua-tra-gop';
       return redirect()->route('page.index',$alias );
    }
   
}