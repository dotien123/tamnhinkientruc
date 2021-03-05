<?php


namespace App\Modules\FrontEnd\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConfigSite;
use App\Models\IntroDetail;
use App\Models\Feature;
use App\Models\Menu;
use App\Models\Comment;
use App\Models\Icon;
use App\Models\PageIntro as THIS;

class IntroduceController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        
  
        // $seo_menu = Menu::where('link', 'introduce.index')->first();

        // $seo_title = @$seo_menu['title_seo'] ? $seo_menu['title'] : 'Giới thiệu';
        // $seo_des = @$seo_menu['description_seo'] ? @$seo_menu['description_seo']  : 'Giới thiệu';
        // $seo_keyword = @$seo_menu['keywords'] ? $seo_menu['title'] : 'Giới thiệu';
        // $seo_robots = \Lib::robotSEO(@$seo_menu['robots']) ? '': '';
        // $seo_image = @$seo_menu['image_seo'];
        // $seo_url_image = '';
        #endregion
        // ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);

        $data = Icon::where('status', 1)->get();
        return view('FrontEnd::pages.introduce.index', [
            'data' => $data,
            'active' => 'people'
        ]);
    }

    public function detail(Request $request, $alias, $id){
        
        $data_itemFN = THIS::where('type',1)->where('status',THIS::STATUS_ACTIVE)->orwhere('type',5)->get();
        $data_item = THIS::where([['alias', $alias], ['status',1], ['id', $id]])->orderBy('created','desc')->first();
        // dd($data_item);
        if(!empty($data_itemFN)){
            foreach($data_itemFN as $item){
                @$item->advantages=json_decode($item->intro_detail->advantages,true);
            }
        }
        
        if(!empty($data_item)){
            $seo_title = @$data_item['title_seo']? $data_item['title'] :$data_item['title'];
            $seo_des = @$data_item['description_seo']? $data_item['title'] :$data_item['title'];
            $seo_keyword = @$data_item['keywords'] ?? $data_item['title'];
            $seo_robots = \Lib::robotSEO(@$data_item['robots']);
            $seo_image = @$data_item['image_seo']?:@$data_item['image'];
            $seo_url_image = !empty($data_item['image_seo']) ? @$data_item->getImageSeoUrl() : @$data_item->getImageUrl();
            ConfigSite::getSeoMeta($seo_title,$seo_des,$seo_keyword,$seo_robots,$seo_image,$seo_url_image);


            $table_name = THIS::table_name;
            $cmt = Comment::getComment($data_item->id, $table_name);
            $banner = Feature::getSlides(181);

            return view('FrontEnd::pages.introduce.detail', [
                'active' => '181',
                'site_title' => $data_item->title ?? 'Giới thiệu',
                'site_title_mini1' => 'GIỚI THIỆU',
                'tableName' =>  $table_name,
                'banner' =>  $banner,
                'cmt' =>  $cmt,
                'site_title_mini2' => 'giới thiệu',
                'data' => $data_itemFN,
                'obj' => $data_item,
            ]);
        }
        return abort(404);
    }
}