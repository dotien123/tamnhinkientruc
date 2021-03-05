<?php

namespace App\Modules\FrontEnd\Controllers;

use App\Libs\Lib;
use App\Models\ConfigSite;
use App\Models\News as THIS;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CustomerVote;
// use App\Models\NewsDetail;
use App\Models\Feature;
use App\Models\Menu;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
class NewsController extends Controller
{
    protected $perpage = 7 ;
    protected $limt_related = 8;
    public function index(Request $request)
    {
        $data = THIS::getAllNews(12);
        return view('FrontEnd::pages.news.index', [
            'active' => 'news',
            'data' => $data,
            
        ]);
     
    }

    public function detail($alias, $id){

        $news = THIS::where([['alias' , $alias], ['id', $id], ['status', 1]])->first();
        if(isset($news->id)){
            $banner = Feature::getSlides(198);
        }else{
            $banner=[];
        }


        if($news['status'] != THIS::STATUS_ACTIVE) {
            return redirect()->route('home');
        }
        if($news){
            #region seo
            $news->cate=THIS::find($news->id)->categories()->get();
            $seo_title = @$news['title_seo']?: @$news['title'];
            $seo_des = @$news['description_seo']?: @$news['description'];
            $seo_keyword = @$news['keywords'] ?? $news['title'];
            $seo_robots = Lib::robotSEO(@$news['robots']);
            $seo_image = @$news['image_seo']?:@$news['image'];
            $seo_url_image = !empty($news['image_seo']) ? @$news->getImageSeoUrl() : @$news->getImageUrl();
            #endregion
            ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);

            $news_related = THIS::getRelatedNewsByCate($news->cate,7,$news->id);
            DB::table('news')->where('alias', $alias)->update(['views' => $news['views'] + 1]);

            $table_name = THIS::table_name;

            $cmt = Comment::getComment($news->id, $table_name);

            $categories =  Category::where([
                ['status', Category::STATUS_ACTIVE],
                ['id', $news->cate_primary],
            ])->first();

            return view('FrontEnd::pages.news.detail', [
                'is_detail' => 1,
                'categories' => $categories,
                'cmt' => $cmt,
                'site_title' => $categories->title ?? 'Tin tức',
                'banner' => $banner,
                'active' => '188',
                'tableName' =>  $table_name,
                'obj' => $news,
                'related' => $news_related, // tin lien quan
            ]);
        }
        return abort(404);
    }

    public function cate($alias = '', $cate_id = 0)
    {
        $banner = Feature::getSlides(198);
       
        $cate = Category::where([
            ['status', Category::STATUS_ACTIVE],
            ['removed', Category::REMOVED_NO],
        ])->select('id', 'alias', 'title', 'robots', 'title_seo', 'description_seo', 'image_seo', 'keywords')->find($cate_id);

        if($cate) {
            $per = 18;
            $lsObj = News::getAllNewsByCate($cate_id, $per);
            #region seo
            $seo_title = @$cate['title_seo']?:$cate['title'];
            $seo_des = @$cate['description_seo']?:@$cate['title'];
            $seo_keyword = @$cate['keywords'] ?? @$cate['title'];
            $seo_robots = Lib::robotSEO(@$cate['robots']) ?? '';
            $seo_image = @$cate['image_seo'];
            $seo_url_image = @$cate->getImageSeoUrl();
            #endregion
            ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);
            return view('FrontEnd::pages.news.index', [
                'active' => '188',
                'site_title' => 'Tin tức',
                'lsObj' => $lsObj,
                'banner' => $banner,
                'cate' => $cate
            ]);
        }
        return redirect()->route('home');
    }

    public function newCate($alias, $id)
    {
        $banner = Feature::getSlides(198);
        $lsObj = THIS::getAllNewsByCate($id, 10);
        $cate  = Category::where('id', $id)->select('title', 'id')->first();

        if($cate) {
            $seo_title = @$cate['title_seo'] ?: $cate['title'];
            $seo_des = @$cate['description_seo'] ?: @$cate['description'];
            $seo_keyword = @$cate['keywords'] ?? @$cate['title'];
            $seo_robots = '';
            $seo_image = @$cate['image_seo'];
            $seo_url_image = @$cate->getImageSeoUrl();
            #endregion
            ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);

            return view('FrontEnd::pages.news.listcate', [
                'active' => '188',
                'data' => $lsObj,
                'site_title' => @$cate['title_seo'] ?? $cate['title'],
                'banner' => $banner,
                'cate_search' => $cate,
            ]);
        }
        abort(404);
    }

}
