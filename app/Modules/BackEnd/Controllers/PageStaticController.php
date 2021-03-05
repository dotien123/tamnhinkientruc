<?php


namespace App\Modules\BackEnd\Controllers;

use App\Libs\LoadDynamicRouter;
use Illuminate\Http\Request;
use App\Models\Page as THIS;
class PageStaticController extends BackendController
{
    protected $timeStamp = 'created';

    public function __construct(){
//        $this->bladeAdd = 'add';
        \View::share('allType', THIS::$type);
        parent::__construct(new THIS(), [
            [
                'title' => 'required|max:250',
                'title_seo' => 'max:250',
                'body' => 'nullable|min:50',
            ]
        ]);
        $this->registerAjax('removeimg', 'ajaxItemImgDel', 'delete');
        LoadDynamicRouter::loadRoutesFrom('FrontEnd');

    }

    public function ajaxItemImgDel(Request $request)
    {
        if($request->id > 0){
            $data = THIS::where('id', $request->id)->where('image', $request->img)->first();
            if($data){
                $data->image = null;
                $data->save();
            }
            return \Lib::ajaxRespond(true, 'ok', ['json' => 'xóa ảnh']);
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }

    
    public function index(Request $request){
        $order = 'published DESC, id DESC';
        $cond = [];
        if ($request->status != '') {
            $cond[] = ['status', $request->status];
        } else {
            $cond[] = ['status', '!=', -1];
        }
        if($request->title != ''){
            $cond[] = ['title','LIKE','%'.$request->title.'%'];
        }
        $time = explode(' - ', \request('time_between'));
        if(is_array($time)) {
            foreach($time as $k => $t) {
                $timeStamp = \Lib::getTimestampFromVNDate($t);
                if (!$k) {
                    array_push($cond, ['published', '>=', $timeStamp]);
                }else {
                    array_push($cond, ['published', '<=', $timeStamp]);
                }
            }
        }
        if(!empty($cond)){
            $data = THIS::where($cond)->orderByRaw($order)->paginate($this->recperpage);
        }else{
            $data = THIS::orderByRaw($order)->paginate($this->recperpage);
        }
        return $this->returnView('index', [
            'data' => $data,
            'search_data' => $request
        ]);
    }
    public function showAddForm() {
        $preview = request('preview');
        $type_view = request('view', 'full');
        return $this->returnView('edit', [
            'preview' => $preview,
            'view' => $type_view,

        ]);
    }

    public function showEditForm($id){
        $preview = request('preview');
        $type_view = request('view', 'full');
        $obj = $this->model::find($id);
        if($obj) {
            set_old($obj);
            return $this->returnView('edit', [
                'obj' => $obj,
                'preview' => $preview,
                'view' => $type_view,
            ]);
        }
        return $this->notfound($id);
    }

    public function beforeSave(Request $request, $ignore_ext = [])
    {
        parent::beforeSave($request); // TODO: Change the autogenerated stu
        if(empty($this->model->title_seo)){
            $this->model->title_seo = $this->model->title;
        }
        if(empty($this->model->link_seo)){
            $this->model->link_seo = \Illuminate\Support\Str::slug($this->model->title);
        }
        if(!empty($request->published)){
            $this->model->published = \Lib::getTimestampFromVNDate($request->published);
        }
        if ($request->hasFile('image_seo')) {
            $this->uploadImage($request, $request->title_seo, 'image_seo');
        }
        unset($this->model->files);
    }
}