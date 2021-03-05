<?php

namespace App\Modules\BackEnd\Controllers;

use App\Libs\LoadDynamicRouter;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\Comment as THIS;

class CommentPostController extends BackendController
{
    protected $timeStamp = 'created';

    //config controller, ez for copying and paste
    public function __construct(){
        $this->bladeAdd = 'add';
        parent::__construct(new THIS());
        LoadDynamicRouter::loadRoutesFrom('FrontEnd');
        \View::share('catOpt', Category::get()->toArray());
        $this->registerAjax('status', 'ajaxStatus');
        $this->registerAjax('reply-cmt', 'ajaxReplyComment');

        \View::share('products', Product::where('status', '>', 0)->get()->toArray());
    }

    public function index(Request $request){
        $cond = [];
        if($request->id != ''){
            $cond[] = ['id', $request->id];
        }else {
            if ($request->status != '') {
                $cond[] = ['status', $request->status];
            } else {
                $cond[] = ['status', '>', 0];
            }
            if ($request->type_id != '') {
                $cond[] = ['type_id', $request->type_id];
            }
            if ($request->uid != '') {
                $cond[] = ['uid', 'LIKE', '%' . $request->uid . '%'];
            }

            if ($request->table != '') {
                $cond[] = ['tableName', $request->table];
            }

            if($request->title != '') {
                $cond[] = ['comment','LIKE','%'.$request->title.'%'];
            }
        }
        if(!empty($cond)) {
            $data = THIS::with('parent')->where($cond)->where('type', '=', 1)->orderByRaw('created DESC, id DESC')->paginate($this->recperpage);
        }else{
            $data = THIS::with('parent')->orderByRaw('created DESC, id DESC')->paginate($this->recperpage);
        }
        return $this->returnView('index', [
            'data' => $data,
            'search_data' => $request,
        ]);
    }

    public function showEditForm($id){
        $data = THIS::find($id);
        $preview = request('preview');
        $type_view = request('view', 'full');
        if(empty($data)){
            return $this->notfound($id);
        }
        set_old($data);
        
        if(isset($data)){
            return $this->returnView('edit', [
                'data' => $data,
                'preview' => $preview,
                'view' => $type_view,
            ]);
        }
        return $this->notfound($id);
    }


    public function beforeSave(Request $request, $ignore_ext = [])
    {
        if($request->aid == 0){
            $this->addReplyComment($request);
        }else{
            $this->editReplyComment($request);
        }
    }
    

    public function ajaxStatus(Request $request){
        if($request->id > 0) {
            $data = $this->model::find($request->id);
            if ($data) {
                $before = $data->status;
                $data->status = $before == 1 ? 2 : 1;
                $data->save();
                \MyLog::do()->add($this->key.'-status', $data->id, $data->status, $before);
                return \Lib::ajaxRespond(true, 'success');
            }
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }
    
    public function addReplyComment(Request $request){
            $cmt = new THIS();
            $cmt->uid = \Auth::user()->id;
            $cmt->type = 1;
            $cmt->customer_name = $request->customer_name;
            $cmt->phone = $request->phone;
            $cmt->url = $request->url;
            $cmt->type_id = $request->type_id;
            $cmt->comment = $request->comment;
            $cmt->tableName = $request->tableName;
            $cmt->action = $request->id;
            $cmt->status = 1;
            $cmt->aid = 1;
            $cmt->created = time();
            $cmt->comment_parent = $request->comment_parent;
            $cmt->save();

            \MyLog::do()->add($this->key.'-add', $cmt->id, $cmt);

            return \Lib::ajaxRespond(true, 'success', $cmt->id);
    }

    public function editReplyComment(Request $request){
        THIS::where('id', $request->id)
        ->update([
            'phone' => $request->phone,
            'customer_name' => $request->customer_name,
            'uid' => \Auth::user()->id,
            'comment' => $request->comment,
            'url' => $request->url,
            'created' => time(),
            ]);

        return \Lib::ajaxRespond(true, 'success', $request->id);
    }

}
