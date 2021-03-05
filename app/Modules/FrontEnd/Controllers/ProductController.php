<?php


namespace App\Modules\FrontEnd\Controllers;


use App\Http\Controllers\Controller;
use App\Libs\Lib;
use App\Models\BaseModel;
use App\Models\Category;
use App\Models\Accessary;
use App\Models\ConfigSite;
use App\Models\Feature;
use http\Url;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Menu;
use Litecms\Block\Models\Category as ModelsCategory;

class ProductController extends Controller
{
    protected $perpage = 9;

    public function index(Request $request)
    {

        // $seo_menu = Menu::where('link', 'product.list')->first();

        // $seo_title = @$seo_menu['title_seo'] ? $seo_menu['title'] : 'DANH SÁCH SẢN PHẨM';
        // $seo_des = @$seo_menu['description_seo'] ? @$seo_menu['description_seo']  : 'DANH SÁCH SẢN PHẨM';
        // $seo_keyword = @$seo_menu['keywords'] ?? 'DANH SÁCH SẢN PHẨM';
        // $seo_robots = Lib::robotSEO(@$seo_menu['robots']) ? '': '';
        // $seo_image = @$seo_menu['image_seo'];
        // $seo_url_image = '';
        // #endregion
        // ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);
        $project = Product::where('status','1')->paginate(12);
        $cate = Category::getPureCate();
        $project_cate = Product::with('category')->limit(10)->orderBy('created', 'DESC')->get();

        return view('FrontEnd::pages.product.index', [
            'project' => $project,
            'cate' => $cate,
            'project_cate' => $project_cate,
            'active' => 'list'
        ]);
    }

    public function getCateData(Request $request){
        if(isset($request->id) && !empty($request->id))
        {
            $data = Category::getProduct($request->id);
            return response()->json([
                'result' => view('FrontEnd::pages.product.option', ['data' => $data])->render(),
            ]);
        }
        return false;
    }

    public function loadmore(Request $r)
    {
        if(isset($r->type) && !empty($r->type))
        {
            $project_cate = Product::with('category')->limit(10*$r->type)->orderBy('created', 'DESC')->get();
            // $number = count($project_cate);
            return response()->json([
                'result' => view('FrontEnd::pages.product.loadmore', ['project_cate' => $project_cate])->render(),
            ]);
        }
        return false;
        
    }

    public function detail($alias, $id)
    {
        $obj = Product::with('category')->where([['alias', $alias], ['id', $id]])->first();
        if ($obj['status'] != BaseModel::STATUS_ACTIVE) {
            return Redirect::to('/', 301);
        }
        if ($obj) {
            // $lsRelated = Product::getListRelatedProductByCateId($obj->cate_primary, $obj->id,8);
            $cate = Product::find($obj->id)->categories()->get();
            if (count($cate) > 0) {
                foreach ($cate as $key => $value) {
                    $product[$key] = Category::find($value->id)->product()->get();
                }
            } else {
                $product = [];
            }
            #region seo
            $dataImg = ProductImage::where('object_id', $obj->id)->get();
            $seo_title = @$obj['title_seo'] ?: $obj['title'];
            $seo_des = trim(html_entity_decode(strip_tags(@$obj['description_seo'] ? @$obj['description_seo'] :   mb_substr(strip_tags(@$obj['component']),0,500) )));
            $seo_keyword = @$obj['keywords'] ?? @$obj['title'];
            $seo_robots = Lib::robotSEO(@$obj['robots']);
            $seo_image = @$obj['image_seo'];
            $seo_url_image = $obj['image_seo'] ? @$obj->getImageUrl('image_seo', 'product') : @$obj->getImageUrl('image', 'product');

            $descrioption = explode(';',$obj->description);
            #endregion
            ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);

            $table_name = Product::tableName;

            $cmt = Comment::getComment($obj->id, $table_name);
            $categories = Product::find($obj->id)->categories()->first();
            return view('FrontEnd::pages.product.detail', [
                'is_detail' => 1,
                'categories' => $categories,
                'cmt' => $cmt,
                'lsRelated' => $product,
                'descrioption' => $descrioption,
                'tableName' => $table_name,
                'obj' => $obj,
                'active' => 'list',
                'menuID' => $categories->id ?? '',
                'dataImg' => $dataImg
            ]);
        }
        return abort(404);
    }

    public function storyCate($alias, $id, Request $request)
    {
        if(isset($id)){
            $banner=Feature::getSlides(-99);
        }else{
            $banner=[];
        }

        // $cate = Category::getCateByIDNew($id);
        $cate =  Product::getCateNo3($id);
        $data = Product::getAllProductByCate($id, 12);
        $lsRelated = Product::inRandomOrder()->take(5)->get();
        $seo_menu = Category::where('id', $id)->first();
        $seo_title = @$seo_menu['title_seo'] ? $seo_menu['title'] : 'Danh sách danh mục sản phẩm';
        $seo_des = @$seo_menu['description_seo'] ? @$seo_menu['description_seo']  : 'Danh sách danh mục sản phẩm';
        $seo_keyword = @$seo_menu['keywords'] ?? 'Danh sách danh mục sản phẩm';
        $seo_robots = Lib::robotSEO(@$seo_menu['robots']) ? '': '';
        $seo_image = @$seo_menu['image_seo'];
        $seo_url_image ='';
        ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);


        return view('FrontEnd::pages.product.story', [
            'site_title' => isset($seo_menu->title) ? $seo_menu->title : '',
            'site_title_mini1' => 'SẢN PHẨM',
            'lsObj' => $data,
            'banner' => $banner,
            'lsRelated' => $lsRelated,
            'cate' => $cate,
            'active' => '182',
            'menuID' => $id,
        ]);
    }


    public function CateChil($alias, $id, Request $request)
    {
        if(isset($id)){
            $banner=Feature::getSlides(-99);
        }else{
            $banner=[];
        }

        $cate   =  Category::where([['status', 1], ['type', 1], ['id', $id]])->select('id', 'title', 'pid')->first();

        $cateP  = Category::where([['status', 1], ['type', 1], ['id', $cate->pid]])->select('id', 'title')->first();
        $data = Product::getAllProductByCate($id, 9);
        $lsRelated = Product::inRandomOrder()->take(5)->get();

        $seo_menu = Category::where('id', $id)->first();
        $seo_title = @$seo_menu['title_seo'] ? $seo_menu['title'] : 'DANH SÁCH SẢN PHẨM';
        $seo_des = @$seo_menu['description_seo'] ? @$seo_menu['description_seo']  : @$cate['title'];
        $seo_keyword = @$seo_menu['keywords'] ??  @$cate['title'];
        $seo_robots = Lib::robotSEO(@$seo_menu['robots']) ? '': '';
        $seo_image = @$seo_menu['image_seo'];
        $seo_url_image ='';
        ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);


        return view('FrontEnd::pages.product.catechil', [
            'site_title' => isset($seo_menu->title) ? $seo_menu->title : '',
            'site_title_mini1' => 'Danh mục sản phẩm',
            'lsObj' => $data,
            'lsRelated' => $lsRelated,
            'banner' => $banner,
            'cate' => $cate,
            'cateP' => $cateP,
            'active' => '182',
            'menuID' => $id,
        ]);
    }

    public function ACE($id, Request $request)
    {
        $banner=Feature::getSlides(-99);
        $cate = Accessary::where('id', $id)->first();
        $data = Product::where([['aces_id', $id], ['acessery' , 1]])->paginate(9);
        $lsRelated = Product::inRandomOrder()->take(5)->get();

        $seo_menu = Category::where('id', $id)->first();
        $seo_title = @$seo_menu['title_seo'] ? $seo_menu['title'] : 'DANH SÁCH PHỤ TÙNG';
        $seo_des = @$seo_menu['description_seo'] ? @$seo_menu['description_seo']  : 'ô tô long biên';
        $seo_keyword = @$seo_menu['keywords'] ??  @$cate['title'];
        $seo_robots = Lib::robotSEO(@$seo_menu['robots']) ? '': '';
        $seo_image = @$seo_menu['image_seo'];
        $seo_url_image ='';
        ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);

        return view('FrontEnd::pages.product.catePK', [
            'site_title' => isset($cate->title) ? $cate->title: '',
            'site_title_mini1' => 'SẢN PHẨM',
            'lsObj' => $data,
            'banner' => $banner,
            'lsRelated' => $lsRelated,
            'cate' => $cate,
            'active' => 'product.index',
            'menuID' => $id,
        ]);
    }

    public function higlight($id)
    {
        $banner=Feature::getSlides(182);
        $cate =  Category::whereIN('id', [154, 158, 163])->orderBy('id', 'ASC')->select('id', 'title', 'pid')->get();
        // $data = Product::getAllProductByCate($id, $this->perpage);

        $seo_menu = Category::where('id', $id)->first();
        $seo_title = @$seo_menu['title_seo'] ? $seo_menu['title_seo'] : 'DANH SÁCH SẢN PHẨM NỔI BẬT';
        $seo_des = @$seo_menu['description_seo'] ? @$seo_menu['description_seo']  : 'DANH SÁCH SẢN PHẨM NỔI BẬT';
        $seo_keyword = @$seo_menu['keywords'] ?? 'DANH SÁCH SẢN PHẨM NỔI BẬT';
        $seo_robots = Lib::robotSEO(@$seo_menu['robots']) ? '': '';
        $seo_image = @$seo_menu['image_seo'];
        $seo_url_image ='';
        ConfigSite::getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image);


        return view('FrontEnd::pages.product.higlight', [
            'site_title' => isset($seo_menu->title) ? $seo_menu->title : 'Sản phẩm nổi bật',
            'site_title_mini1' => 'SẢN PHẨM',
            'banner' => $banner,
            'cate' => $cate,
            'active' => '182',
        ]);
    }



}
