<?php

namespace App\Modules\BackEnd\Controllers;

use App\Models\TagDetail;
use Illuminate\Http\Request;

use App\Models\Tag as THIS;

class TagController extends BackendController
{
    protected $timeStamp = 'created';

    //config controller, ez for copying and paste
    public function __construct(){
        parent::__construct(new THIS());
        $this->bladeAdd = 'add';
        $this->registerAjax('tag-add', 'ajaxAddTag', 'add');
        $this->registerAjax('tag-del', 'ajaxRemoveTag', 'delete');
        $this->registerAjax('tag-suggest', 'ajaxLoadSuggestTag');
    }

    protected function ajaxLoadSuggestTag(Request $request){
        if(!empty($request->type)) {
            $tags = THIS::getTags($request->type);
            $data = [];
            foreach ($tags as $item){
                $data[] = $item['title'];
            }
            return \Lib::ajaxRespond(true, 'success', $data);
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }

    protected function ajaxAddTag(Request $request){
        if (!empty($request->tag)) {
            $safe_title = str_slug($request->tag);
            $tag = THIS::where([
                ['safe_title', '=', $safe_title],
                ['type', '=', $request->type],
            ])->first();
            if (empty($tag)) {
                $tag = new THIS();
                $tag->title = $request->tag;
                $tag->safe_title = $safe_title;
                $tag->type = $request->type;
                $tag->created = time();
                $tag->save();
                \MyLog::do()->add($this->key.'-add', $tag->id, $tag);
            }
            return \Lib::ajaxRespond(true, 'success', $tag->id);
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }

    protected function ajaxRemoveTag(Request $request){
        if (!empty($request->tag)) {
            $safe_title = str_slug($request->tag);
            $tag = THIS::where([
                ['safe_title', '=', $safe_title],
                ['type', '=', $request->type]
            ])->first();
            if (!empty($tag)) {
                switch ($request->type) {
                    case 1:
                        if ($request->id > 0) {
                            TagDetail::where([
                                ['tag_id', '=', $tag->id],
                                ['object_id', '=', $request->id]
                            ])->delete();
                        }
                        //kiem tra neu ko trong che do su dung thi xoa
                        $check = TagDetail::where([
                            ['tag_id', '=', $tag->id]
                        ])->first();
                        if (empty($check)) {
                            $tag->delete();
                            \MyLog::do()->add($this->key.'-remove', $tag->id);
                        }
                        break;
                }
            }
            return \Lib::ajaxRespond(true, 'success', $tag->id);
        }
        return \Lib::ajaxRespond(false, 'Không tìm thấy dữ liệu');
    }
}
