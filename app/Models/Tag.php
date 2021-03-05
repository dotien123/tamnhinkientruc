<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags';
    public $timestamps = false;
    const TYPE = [
        1 => 'news',
    ];

    public static function getTags($type = 1){
        return self::where('type', '=', $type)
            ->get()
            ->toArray();
    }

    public static function getTagsByID($type = 1, $id){
        return self::where([['type', '=', $type], ['id', $id]])
            ->get()
            ->toArray();
    }

    public static function getNewsTags($id = 0){
        $data = \DB::table('tags')
            ->join('tag_details', 'tags.id', '=', 'tag_details.tag_id')
            ->join('news', 'news.id', '=', 'tag_details.object_id')
            ->select('tags.title', 'tags.id', 'tags.safe_title')
            ->where('tags.type', 1);
        if($id > 0){
            $data = $data->where('news.id', '=', $id);
        }
        return $data->get()->toArray();
    }

    
    public static function addTags($tags, $type, $id){
        //lay thong tin tag
        $tags = explode(',', $tags);
        foreach ($tags as $k => $v){
            $tags[$k] = str_slug($v);
        }
        $tags = self::select('id')
            ->where('type', '=', $type)
            ->whereIn('safe_title', $tags)
            ->get()->toArray();
        if(!empty($tags)) {
            $insertData = [];
            foreach ($tags as $item) {
                $insertData[] = [
                    'object_id' => $id,
                    'tag_id' => $item['id'],
                    'type' => $type
                ];
            }
            if (!empty($insertData)) {
                //xoa het tag cu
                TagDetail::where('object_id', $id)
                    ->where('type', $type)
                    ->delete();
                //chen moi
                TagDetail::insert($insertData);

                return true;
            }
        }
        return false;
    }
}
