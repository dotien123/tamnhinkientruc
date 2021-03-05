<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SEOMeta;
use OpenGraph;
use Twitter;
class ConfigSite extends Model
{
    //
    const table_name = '__configs';
    protected $table = self::table_name;
    public $timestamps = false;
    protected $primaryKey = 'key';

    public static function setConfig($key = '', $value = '') {
        $record = ConfigSite::where('key', $key)->first();
        if(empty($record)){
            $record = new ConfigSite();
            $record->key = $key;
        }
        $record->value = $value;
        return $record->save();
    }

    public static function getConfig($key = '', $def = '') {
       
        $record = ConfigSite::where('key', $key)->first();

        if(!empty($record)) {
            $data = $record->value;

            $value = !empty($data) ? json_decode($data, true) : null;
            if (!empty($value['image'])) {
                $value['image_medium_seo'] = \ImageURL::getImageUrl($value['image'], 'config', 'medium_seo');

                $value['image_seo'] = \ImageURL::getImageUrl($value['image'], 'config', 'seo');
                
            }
            if (!empty($value['image_dev'])) {
                $value['images_dev'] = \ImageURL::getImageUrl($value['image_dev'], 'config', 'original');
            }
            if (!empty($value['logo'])) {
                $value['logo_images'] = \ImageURL::getImageUrl($value['logo'], 'config', 'original');
            }
            if (!empty($value['favicon'])) {
                $value['favicon_images'] = \ImageURL::getImageUrl($value['favicon'], 'config', 'original');
            }
            if(!empty($value['banner_contact'])){
                $value['banner_contact_img'] = \ImageURL::getImageUrl($value['banner_contact'] , 'config' , 'original');
            }
            if(!empty($value['logo_footer'])){
                $value['logo_footer_img'] = \ImageURL::getImageUrl($value['logo_footer'] , 'config' , 'original');
            }
            return json_encode($value);
        }
        return $def;
    }

    public static function getSeo($seo_title = '', $seo_des = '', $seo_keyword = '', $seo_robots = '', $seo_image = '', $seo_url_image = ''){
        $data = self::getConfig('config');
        $data = !empty($data) ? @json_decode($data,true) : [];
        $return = [];
        if(!empty($data)){
            $seo_title = @$seo_title?:$data['site_name'];
            $seo_des = @$seo_des?:$data['description'];
            $seo_keyword = @$data['keywords']?:$seo_keyword;
            //$seo_robots = Lib::robotSEO(@$data['robots']);
            $seo_image = @$data['image_seo'];
            $seo_url_image = (isset($data['image_seo']) ? $data['image_seo'] : $seo_image);
            SEOMeta::setTitle($seo_title);
            SEOMeta::setDescription($seo_des);
            SEOMeta::setKeywords($seo_keyword);
            //SEOMeta::setRobots($seo_robots);

            OpenGraph::setTitle($seo_title);
            OpenGraph::setDescription($seo_des);
            OpenGraph::setUrl(url()->current());
            OpenGraph::addProperty('type', 'object');
            OpenGraph::setSiteName(config('app.name'));
            OpenGraph::addImage($seo_url_image, ['width' => 480, 'height' => 360]); // add image url

            Twitter::setTitle($seo_title); // title of twitter card tag
            Twitter::setSite(config('app.name')); // site of twitter card tag
            Twitter::setDescription($seo_des); // description of twitter card tag
            Twitter::setUrl(url()->current()); // url of twitter card tag
            Twitter::setImage($seo_url_image); // add image url


        }
        return $return;
    }

    static function getSeoMeta($seo_title, $seo_des, $seo_keyword, $seo_robots, $seo_image, $seo_url_image) {
        SEOMeta::setTitle($seo_title);
        SEOMeta::setDescription($seo_des);
        SEOMeta::setKeywords($seo_keyword);
        SEOMeta::setRobots($seo_robots);

        OpenGraph::setTitle($seo_title);
        OpenGraph::setDescription($seo_des);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'object');
        OpenGraph::setSiteName(config('app.name'));
        OpenGraph::addImage($seo_url_image, ['width' => 480, 'height' => 360]); // add image url

        Twitter::setTitle($seo_title); // title of twitter card tag
        Twitter::setSite(config('app.name')); // site of twitter card tag
        Twitter::setDescription($seo_des); // description of twitter card tag
        Twitter::setUrl(url()->current()); // url of twitter card tag
        Twitter::setImage($seo_url_image); // add image url
    }

}
