<?php

namespace App\Modules\BackEnd\Controllers;

use App\Libs\LoadDynamicRouter;
use App\Models\Category;
use App\Models\NewsCate;
use Illuminate\Http\Request;
use App\Models\IOSeach;
use App\Models\Tag;
use App\Models\Statistics;
use App\Models\News as THIS;
use App\Models\Author;

class NewsController extends BackendController
{
    protected $timeStamp = 'created';
    protected $tagID = 1;
    protected $recperpage = 20;
    //config controller, ez for copying and paste
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
        \View::share('catOpt', Category::getCat(2));
        \View::share('tagType', $this->tagID);
        $this->registerAjax('removeimg', 'ajaxItemImgDel', 'delete');

    }

    public function ajaxItemImgDel(Request $request)
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

    public function index(Request $request){
        $order = 'news.created DESC';
        $cond = [];
        if ($request->status != '') {
            $cond[] = ['news.status', $request->status];
        } else {
            $cond[] = ['news.status', '!=', -1];
        }
        if($request->title != ''){
            $cond[] = ['news.title','LIKE','%'.$request->title.'%'];
        }
        if($request->lang != ''){
            $cond[] = ['news.lang','=',$request->lang];
        }
        if($request->type != ''){
            $cond[] = ['news_categories.cate_id','=',$request->type];
        }
        $time = explode(' - ', \request('time_between'));
        if(is_array($time)) {
            foreach($time as $k => $t) {
                $timeStamp = \Lib::getTimestampFromVNDate($t);
                if (!$k) {
                    array_push($cond, ['news.published', '>=', $timeStamp]);
                }else {
                    array_push($cond, ['news.published', '<=', $timeStamp]);
                }
            }
        }
        if(!empty($cond)) {
            if($request->type ==null)
            $data = THIS::where($cond)->orderByRaw($order)->paginate($this->recperpage);
            else
            $data = THIS::leftJoin('news_categories', 'news_categories.new_id', '=', 'news.id')->where($cond)->orderByRaw($order)->paginate($this->recperpage);
        }else{
            $data = THIS::orderByRaw($order)->paginate($this->recperpage);
        }
        foreach ($data as $key => $value) {
            @$value->cate=THIS::find($value->id)->categories()->get();
        }
        return $this->returnView('index', [
            'lsObj' => $data,
            'search_data' => $request,
            'admin' => '',
            'customer' => ''
        ]);
    }

    public function showAddForm() {
        $preview = request('preview');
        $type_view = request('view', 'full');
        $lsCate = Category::getTreeCateCheckboxByType(2, [], 0);
        return $this->returnView('edit', [
            'preview' => $preview,
            'view' => $type_view,
            'lsCate' => $lsCate
        ]);
    }

    public function showEditForm($id){
        $preview = request('preview');
        $type_view = request('view', 'full');
        $tags = Tag::getNewsTags($id);
        if(!empty($tags)){
            $tmp = [];
            foreach ($tags as $item){
                $tmp[] = $item->title;
            }
            $tags = implode(',', $tmp);
        }else{
            $tags = '';
        }
        $obj = THIS::with(['categories' => function ($q) {
            $q->select('id', 'title', 'status', 'type', 'sort')->get();
        }])->find($id);
        if($obj) {
            $selected = [];
            $categories = $obj->categories->toArray();
            foreach ($categories as $cate) {
                $selected[] = $cate['id'];
            }
            $lsCate = Category::getTreeCateCheckboxByType(2, $selected, $obj->cate_primary);
            set_old($obj);
            // dump(THIS::with('detail')->find($id));
            return $this->returnView('edit', [
                'obj' => $obj,
                'tags' => $tags,
                'preview' => $preview,
                'view' => $type_view,
                'lsCate' => $lsCate
            ]);
        }
        return $this->notfound($id);
        
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
    
        $this->model->views = THIS::VIEWS;
        $this->model->title_seo = !empty($request->title_seo) ? $request->title_seo : $request->title;
        $this->model->author = (\Auth::check()) ? \Auth::user()->id : 'Vô danh';
        $this->model->alias = isset($request->alias) ? $request->alias : str_slug($request->title);

        if($this->model->removed == THIS::REMOVED_NO && $this->model->status != -1) {
            if($request->status == 'pending') {
                $this->model->status = THIS::STATUS_INACTIVE;
            }else {
                $this->model->status = @$request->status?:THIS::STATUS_INACTIVE;
            }
        }else {
            $this->model->status = -1;
        }
        if(!empty($request->published)){
            $this->model->published = \Lib::getTimestampFromVNDate($request->published);
        }
        if ($request->hasFile('image_seo')) {
            $this->uploadImage($request, $request->title_seo, 'image_seo');
        }
        // xoa truong thua
        unset($this->model->tags, $this->model->cate_ids, $this->model->files);
    }

    public function afterSave(Request $request)
    {
        // insert tag
        if(!empty($request->tags) && \Lib::can(false,'tag','news')) {
            Tag::addTags($request->tags, 1, $this->editID);
        }
        /*if(!empty($request->cate_par)) {
            NewsCate::addCateById($this->editID, $request->cate, $request->cate_par);
        }*/
        if(!empty($request->cate_ids)) {
            NewsCate::addCateById($this->editID, $request->cate_ids);
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
        $old->name  = $this->model->title;
        $old->alias  = $this->model->alias;
        $old->cate_id  = $this->model->cate_id?:0;
        $old->object_id  = $this->model->id;
        $old->table  = THIS::table_name;
        $old->keyword  = $this->model->title;
        $old->created = time();
        $old->save();

    }


}
