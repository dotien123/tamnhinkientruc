<?php

namespace App\Modules\BackEnd\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Icon as THIS;

class IconController extends BackendController
{
    protected $timeStamp = 'created';
    protected $recperpage = 10;

    //config controller, ez for copying and paste
    public function __construct(){
        $this->bladeAdd = 'add';
        parent::__construct(new THIS(),[
            [
                'title' => 'required|max:250',
                'image' => 'required|mimes:jpeg,jpg,png,gif,svg',
                'link' => 'nullable|url',
            ]
        ]);
        $this->registerAjax('delete', 'ajaxDelete', 'delete');
        $this->registerAjax('removeimg', 'ajaxItemImgDel', 'delete');

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
        $order = 'created DESC, id DESC';
        $cond = [];
        if ($request->status != '') {
            $cond[] = ['status', $request->status];
        }else {
            $cond[] = ['status', '>',-1];
        }

        if($request->title != ''){
            $cond[] = ['title','LIKE','%'.$request->title.'%'];
        }

        if($request->position != ''){
            $cond[] = ['position', $request->position];
        }
       
        $time = explode(' - ', \request('time_between'));
        if(is_array($time)) {
            foreach($time as $k => $t) {
                $timeStamp = \Lib::getTimestampFromVNDate($t);
                if (!$k) {
                    array_push($cond, ['created', '>=', $timeStamp]);
                }else {
                    array_push($cond, ['created', '<=', $timeStamp]);
                }
            }
        }
        if(!empty($cond)) {
            $data = THIS::where($cond)->orderByRaw($order)->paginate($this->recperpage);
        }else{
            $data = THIS::orderByRaw($order)->paginate($this->recperpage);
        }
        return $this->returnView('index', [
            'lsObj' => $data,
            'search_data' => $request
        ]);
    }

    public function buildValidate(Request $request){

        if($this->editMode){
            $this->ignoreValidate('image');
            if ($request->hasFile('image')) {
                $this->addValidate(['image' => 'mimes:jpeg,jpg,png,gif,svg']);
            }
        }
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
        $data = THIS::find($id);
        
        set_old($data);
        return $this->returnView('edit', [
            'obj' => $data,
            'preview' => $preview,
            'view' => $type_view,
        ]);
    }

    function ajaxDelete(Request $request) {
        $id = $request->id?:0;
        if(!$id) {
            return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu!');
        }
        $obj = THIS::find($id);
        if($obj){
            $removed = ($request->removed == "true") ? THIS::REMOVED_NO : THIS::REMOVED_YES;
            $obj->update(['removed' => $removed]);
            if($request->removed != "true") {
                $this->delete($id);
            }else {
                $obj->update(['status' => THIS::STATUS_INACTIVE]);
            }
            return \Lib::ajaxRespond(true, 'Xóa dữ liệu thành công');
        }
        return \Lib::ajaxRespond(true, 'Xóa dữ liệu thành công');

    }
}
