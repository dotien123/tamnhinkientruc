<?php


namespace App\Modules\BackEnd\Controllers;


use App\Libs\LoadDynamicRouter;
use App\Models\BaseModel;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Status;
use App\Models\Vehicles;
use App\Models\IOSeach;
use App\Models\NewsCate;
use App\Models\Product as THIS;
use App\Models\ProductImage;
use App\Models\ProductCate;
use App\Models\Accessary;
use App\Models\ProductVehicles;
use App\Models\Payload;
use App\Models\Tag;
use App\Models\Unit;
use App\Models\ProductPrice;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;

class ProductController extends BackendController
{
    protected $timeStamp = 'created';
    public function __construct(){
        parent::__construct(new THIS(),[
            [
                'title' => 'required|max:250',
                'title_seo' => 'max:250',
            ],
            [
                'title.required' => 'Tiêu đề không được bỏ trống',
                'title.max' => 'Tiêu đề không được quá 250 ký tự',
            ]

        ]);
        LoadDynamicRouter::loadRoutesFrom('FrontEnd');
        \View::share('catOpt', Vehicles::get());
        $this->registerAjax('load', 'ajaxImageLoad', 'view');
        $this->registerAjax('upload_img', 'ajaxItemUploadMulti', 'add');
        $this->registerAjax('remove_img', 'ajaxItemImgDel', 'delete');
        $this->registerAjax('removeimg1', 'ajaxItemImgDel1', 'delete');
        $this->registerAjax('change-pos', 'ajaxItemChangePos', 'edit');
    }

    public function ajaxItemImgDel1(Request $request)
    {
        if($request->id > 0){
            $data = THIS::where('id', $request->id)->where('image', $request->img)->first();
            if($data){
                $data->image = null;
                $data->save();
                return \Lib::ajaxRespond(true, 'ok', ['json' => 'xóa ảnh']);
            }
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }

    public function index(Request $request)
    {
        $recperpage = 10;
        $order = 'products.created DESC, products.id DESC';
        $cond = [['status','>',0]];

        if($request->title != ''){
            $cond[] = ['products.title','LIKE','%'.$request->title.'%'];
        }

        if($request->type != ''){
            $cond[] = ['products_vehicles.v_id','=',$request->type];
        }

        if($request->brand != ''){
            $cond[] = ['products.brand_id','=',$request->brand];
        }

        if($request->tinh_trang != ''){
            $cond[] = ['products.tt_id','=',$request->tinh_trang];
        }

        if($request->accessory > -1) {
            $cond[] = ['products.acessery','=',$request->accessory];
        }

        if($request->type != '')
        $data = THIS::getAllDetailProductWithTitle2($cond, $order, $recperpage);
        else
        $data = THIS::getAllDetailProductWithTitle($cond, $order, $recperpage);
        // $dataCate = THIS::find(28)->categories()->get();
        foreach ($data as $key => $value) {
            @$value->cate = THIS::find($value->id)->categories()->get(); 
        }

        $brand = Brand::select('id', 'title')->get();
        $tt = Status::get();
        return $this->returnView('index', [
            'lsbr' => $brand,
            'lsObj' => $data,
            'search_data' => $request,
            'tt' => $tt,
            'admin' => '',
            'customer' => ''
        ]);
    }

    public function showAddForm()
    {

        $preview = request('preview');
        $type_view = request('view', 'full');
        $lsCate = Category::getTreeCateCheckboxByType(1, [], 0);    
        $lsBrand = Brand::getTreebrandCheckboxByType(1, [], 0);
        $lsVeh = Vehicles::getTreeVehiclesCheckboxByType(1, [], 0);
        $status = Status::where('status', 1)->get();
        $price = ProductPrice::getlist();
        $pricepk = ProductPrice::getlistPk();
        $payload = Payload::getlist();
        $accessary = Accessary::where('status', 1)->select('id', 'title')->get();

        return $this->returnView('edit', [
            'payload' => $payload,
            'price' => $price,
            'pricepk' => $pricepk,
            'preview' => $preview,
            'view' => $type_view,
            'lsCate' => $lsCate,
            'lsBrand' => $lsBrand,
            'lsVeh'  => $lsVeh,
            'tt' => $status,
            'tt_id' => '',
            'accessary' => $accessary,
        ]);
    }

    public function showEditForm($id)
    {        
        $preview = request('preview');
        $type_view = request('view', 'full');
        $tpl['preview'] = $preview;
        $tpl['view'] = $type_view;
        $tpl['price'] = ProductPrice::getlist();
        $tpl['pricepk'] = ProductPrice::getlistPk();
        $tpl['payload'] = Payload::getlist();
        
        $obj = THIS::with(['categories' => function ($q) {
            $q->select('id', 'title', 'status', 'type', 'sort')->get();
        }])->findOrFail($id);
        $tpl['lsBrand'] = Brand::getTreebrandCheckboxByType(1, $obj->brand_id); 
        $tpl['accessary'] = Accessary::where('status', 1)->select('id', 'title')->get();
        $tpl['tt'] = Status::get();
        $tpl['tt_id'] = $obj->tt_id;
        $tpl['aces_id'] = $obj->aces_id;
        
        if($obj->vehicles || $obj->categories)
        {
            if($obj->vehicles) {
                $selected_veh = [];
                $vehicles = $obj->vehicles->toArray();
                foreach ($vehicles as $veh) {
                    $selected_veh[] = $veh['id'];
                }
                $lsVeh = Vehicles::getTreeVehiclesCheckboxByType(1, $selected_veh, '');
                $tpl['lsVeh'] = $lsVeh;
            }

            if($obj->categories) {
                $selected = [];
                $categories = $obj->categories->toArray();
                $brand = $this->model->brand;
                foreach ($categories as $cate) {
                    $selected[] = $cate['id'];
                }
                $lsCate = Category::getTreeCateCheckboxByType(1, $selected, $obj->cate_primary);
                $tpl['lsCate'] = $lsCate;
            }

            $tpl['obj'] = $obj;
            set_old($tpl['obj']);

            return $this->returnView('edit', $tpl);
        }
        return $this->notfound();
    }

    public function buildValidate(Request $request){
        if ($request->hasFile('image')) {
            $this->addValidate(['image' => ['mimes:jpeg,jpg,png,gif,webp','Ảnh đại diện']]);
        }

        if ($request->hasFile('image_seo')) {
            $this->addValidate(['image_seo' => ['mimes:jpeg,jpg,png,gif,webp','Ảnh seo']]);
        }
    }

    public function beforeSave(Request $request, $ignore_ext = [])
    {
        parent::beforeSave($request); // TODO: Change the autogenerated stub
        if($request->unit) {
            $unit = Unit::orWhere('title', $request->unit)->orWhere('id', $request->unit)->first();
            if($unit) {
                $this->model->unit = $unit['id'];
            }else {
                $unit = Unit::insertGetId(['title' => $request->unit, 'created' => time()]);
                $this->model->unit = $unit;
            }
        }
        $this->model->brand_id = !empty($request->brand_id) ? $request->brand_id : Null;
        $this->model->title_seo = !empty($request->title_seo) ? $request->title_seo : $request->title;
        $this->model->alias = isset($request->alias) ? $request->alias : str_slug($request->title);
      

        if ($request->hasFile('image_seo')) {
            $this->uploadImage($request, $request->title_seo, 'image_seo');
        }
        // xoa truong thua
        unset($this->model->tags, $this->model->cate_ids,$this->model->veh_id, $this->model->files,$this->model->uploadify_hotel_img,$this->model->img_upload_for_add);
    }

    public function afterSave(Request $request)
    {

        if(!empty($request->veh_id)) {
            ProductVehicles::addVehiById($this->editID, $request->veh_id);
        }

        if(!empty($request->cate_ids)) {
            ProductCate::addCateById($this->editID, $request->cate_ids);
        }
        // thêm data vào iosearch
        //  mọi thứ đều đc lưu trước khi vào search vì thế vẫn update
        $old = IOSeach::where([
            ['object_id', $this->model->id],
            ['table', THIS::table_name],
        ])->first();

        if(!$old) {
            //  thêm mới + init
            $old = new IOSeach();
        }
        //dd($this->model->id);

        $old->name  = $this->model->title;
        $old->alias  = $this->model->alias;
        $old->cate_id  = $this->model->cate_id?:0;
        $old->object_id  = $this->model->id;
        $old->table  = THIS::table_name;
        $old->keyword  = $this->model->title;
        $old->created = time();
        $old->save();
        if(!empty($request->img_upload_for_add)) {
            ProductImage::whereIn('id',explode(',',$request->img_upload_for_add))->update(['object_id'=>$this->model->id]);
        }

    }

    protected function ajaxImageLoad(Request $request)
    {
        return \Lib::ajaxRespond(true, 'ok', ['images' => THIS::getImageGallery($request->object_id,$request->type)]);
    }

    protected function ajaxItemUploadMulti(Request $request){
        if ($request->hasFile('Filedata')) {
            $image = $request->file('Filedata');
            if ($image->isValid()) {
                $title = basename($image->getClientOriginalName(), '.'.$image->getClientOriginalExtension());
                $fname = $this->uploadImage($request, $title, 'Filedata');
                if(!empty($fname)){
                    $imgGallery = new ProductImage();
                    $imgGallery->object_id = $request->object_id;
                    $imgGallery->image = $fname;
                    $imgGallery->created = time();
                    $imgGallery->type = $request->type;
                    $imgGallery->user_id = \Auth::id();
                    $imgGallery->sort = ProductImage::getSortInsert($request->lang);
                    $imgGallery->save();

                    if(empty($imgGallery->object_id)) {
                        return \Lib::ajaxRespond(true, 'ok', ['id' => $imgGallery->id]);
                    }else {
                        return \Lib::ajaxRespond(true, 'ok', ['images' => THIS::getImageGallery($request->object_id,$request->type)]);
                    }
                }
                return \Lib::ajaxRespond(false, 'Upload ảnh thất bại!');
            }
            return \Lib::ajaxRespond(false, 'File không hợp lệ!');
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy ảnh!');
    }

    protected function ajaxItemImgDel(Request $request){
        if($request->id > 0){
            $data = ProductImage::where('id',$request->id)->where('object_id',$request->object_id)->where('type',$request->type)->first();
            if($data){
                $data->delete();
                return \Lib::ajaxRespond(true, 'ok', ['images' => THIS::getImageGallery($request->object_id,$request->type)]);
            }
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }

    protected function ajaxItemChangePos(Request $request){
        if($request->id > 0 && $request->next > 0 && $request->type != ''){
            $next = ProductImage::find($request->next);
            $cur  = ProductImage::find($request->id);
            if($next && $cur){
                $cur->sort = $request->type == 'left' ? ($next->sort + 1) : ($next->sort - 1);
                $cur->save();
                return \Lib::ajaxRespond(true, 'ok');
            }
        }
        return \Lib::ajaxRespond(false, 'Dữ liệu không chính xác');
    }

}