<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class IntroDetail extends Model
{
    //
    protected $table = 'intro_detail';
    const KEY = 'intro_detail';
    const table_name = 'intro_detail';
    public $timestamps = false;

    public $fillable = ['advantages', 'highlights', 'banner', 'background_parameter_video','spec_template', 'specifications'];

    public static function  returnAdvantages(Request $request,&$arr_unset)
    {
        $title_advantages = $request->title_advantages;
        $content_advantages = $request->content_advantages;
        $image_advantages = $request->image_advantages;
        $image_advantages_name_save = $request->input('image_advantages_name_save');
        $arr_unset[] = 'title_advantages';
        $arr_unset[] = 'content_advantages';
        $arr_unset[] = 'image_advantages';
        $arr_unset[] = 'image_advantages_name_save';

        $arr_advantages = [];
        if(!empty($title_advantages)) {
            for($i=0;$i<count($title_advantages);$i++) {
                if (!empty($image_advantages[$i])){
                    $fname = \ImageURL::makeFileName($title_advantages[$i].'-advantages'.$i, $image_advantages[$i]->getClientOriginalExtension());
                    \ImageURL::upload($image_advantages[$i], $fname, 'intro_detail');
                }elseif(!empty($image_advantages_name_save[$i])){
                    $fname = $image_advantages_name_save[$i];
                }
                if(!isset($fname))
                    $fname='';
                $arr_advantages[] = ['image_advantages' => '', 'img_advantages_name' => '', 'title_advantages' => $title_advantages[$i], 'content_advantages' => $content_advantages[$i], 'image_advantages_edit' => $fname];
            }
        }
        return json_encode($arr_advantages, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }
    public static function  returnHighlights(Request $request,&$arr_unset)
    {
        $title_highlights = $request->title_highlights;
        $content_highlights = $request->content_highlights;
        $image_highlights = $request->image_highlights;
        $image_highlights_name_save = $request->input('image_highlights_name_save');
        $arr_unset[] = 'title_highlights';
        $arr_unset[] = 'content_highlights';
        $arr_unset[] = 'image_highlights';
        $arr_unset[] = 'image_highlights_name_save';

        $arr_highlights = [];
        if(!empty($title_highlights)) {
            for($i=0;$i<count($title_highlights);$i++) {
                if (!empty($image_highlights[$i])){
                    $fname = \ImageURL::makeFileName($title_highlights[$i].'-highlights', $image_highlights[$i]->getClientOriginalExtension());
                    \ImageURL::upload($image_highlights[$i], $fname, 'intro_detail');
                }elseif(!empty($image_highlights_name_save[$i])){
                    $fname = $image_highlights_name_save[$i];
                }
                $arr_highlights[] = ['image_highlights' => '', 'img_highlights_name' => '', 'title_highlights' => $title_highlights[$i], 'content_highlights' => $content_highlights[$i], 'image_highlights_edit' => $fname];
            }
        }

        return json_encode($arr_highlights, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }
    public static function  returnBanner(Request $request,&$arr_unset)
    {
        $title_banner = $request->title_banner;
        $link_banner = $request->link_banner;
        $image_banner = $request->image_banner;
        $image_banner_name_save = $request->input('image_banner_name_save');
        $arr_unset[] = 'title_banner';
        $arr_unset[] = 'link_banner';
        $arr_unset[] = 'image_banner';
        $arr_unset[] = 'image_banner_name_save';

        $arr_banner = [];
        if(!empty($title_banner)) {
            for($i=0;$i<count($title_banner);$i++) {
                if (!empty($image_banner[$i])){
                    $fname = \ImageURL::makeFileName($title_banner[$i].'-banner', $image_banner[$i]->getClientOriginalExtension());
                    \ImageURL::upload($image_banner[$i], $fname, 'intro_detail');
                }elseif(!empty($image_banner_name_save[$i])){
                    $fname = $image_banner_name_save[$i];
                }
                $arr_banner[] = ['image_banner' => '', 'img_banner_name' => '', 'title_banner' => $title_banner[$i], 'link_banner' => $link_banner[$i], 'image_banner_edit' => $fname];
            }
        }
        return json_encode($arr_banner, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }

    public static function  returnBackgroundParamVideo(Request $request,&$arr_unset)
    {
        $background = $request->image_background;
        $image_background_name_save = $request->input('image_background_name_save');
        $long = $request->long;
        $wide = $request->wide;
        $high = $request->high;
        $long_base = $request->long_base;
        $video_id = $request->video_id;
        $arr_unset[] = 'image_background';
        $arr_unset[] = 'image_background_name_save';
        $arr_unset[] = 'long';
        $arr_unset[] = 'wide';
        $arr_unset[] = 'high';
        $arr_unset[] = 'long_base';
        $arr_unset[] = 'video_id';

        $param = [];
        if (!empty($background)){
            $fname = \ImageURL::makeFileName('background', $background->getClientOriginalExtension());
            \ImageURL::upload($background, $fname, 'intro_detail');
        }elseif(!empty($image_background_name_save)){
            $fname = $image_background_name_save;
        }
        $param [] = ['long' => $long, 'wide' => $wide, 'high' => $high, 'long_base' => $long_base];
        $arr_background_param_video = ['background' => $fname, 'video_id' => $video_id, 'param' => $param];


        return json_encode($arr_background_param_video, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }

    public static function  returnSpecTemplate(Request $request, &$arr_unset){
        $parameter = $request->parameter;
        $arr_unset[] = 'parameter';
        $arr_parameter = [];
        if(!empty($parameter)) {
            for($i=0;$i<count($parameter);$i++) {
                $detail_spec = $request->input('detail_spec_'.$i);
                $arr_unset[] = 'detail_spec_'.$i;
                $arr_detail_spec = [];
                if (!empty($detail_spec)){
                    for ($ds = 0; $ds<count($detail_spec); $ds++){
                        $arr_detail_spec[] = ['detail_spec' => $detail_spec[$ds]];
                    }
                }
                $arr_parameter[] = ['parameter' => $parameter[$i],'detailSpec' => $arr_detail_spec];
            }
        }
        return json_encode($arr_parameter,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }

    public static function  returnSpecifications(Request $request, &$arr_unset){
        $specGroup = $request->input('specGroup');
        $arr_unset[] = 'specGroup';
        $arr_specGroup = [];
        if (!empty($specGroup)){
            for($i = 0; $i<count($specGroup); $i++){
                $parameter = $request->parameter;
                $arr_unset[] = 'parameter';
                if (!empty($parameter)){
                    $arr_row_detail_spec_group = [];
                    for ($j = 0; $j<count($parameter); $j++){
                        $detail_spec = $request->input('detail_spec_'.$j);
                        $arr_unset[] = 'detail_spec_'.$j;
                        $arr_detail_spec_group = [];
                        if (!empty($detail_spec)){
                            for ($k = 0; $k<count($detail_spec); $k++){
                                $detail_spec_group = $request->input('detail_spec_group_'.$i.'_'.$k.'_'.$j);
                                $arr_unset[] = 'detail_spec_group_'.$i.'_'.$k.'_'.$j;
                                if (!empty($detail_spec_group)){
                                    for ($z = 0; $z<count($detail_spec_group); $z++){
                                        $arr_detail_spec_group [] = ['detail_spec_group' => $detail_spec_group];
                                    }
                                }
                            }
                            $arr_row_detail_spec_group [] = ['ColdetailSpecGroup' => $arr_detail_spec_group];
                        }
                    }
                }
                $arr_specGroup [] = ['specGroup' => $specGroup[$i],'detailSpecGroup' => $arr_row_detail_spec_group];
            }
        }
        return json_encode($arr_specGroup,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }

    public static function getIntroDetailByID($id){
        return self::where('intro_id', $id)->first();
    }

}
