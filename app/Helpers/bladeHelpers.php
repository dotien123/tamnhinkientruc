<?php
/**
 * Created by PhpStorm.
 * User: Tannv
 * Date: 2019-06-30
 * Time: 09:48
 */
if (! function_exists('old_blade')) {

    function old_blade($key = null, $default = null)
    {
        $default = empty($default) ? config('helper.data_edit') : $default;
        return app('request')->old($key, optional($default)->$key);
    }
}
if (! function_exists('set_old')) {

    function set_old($data = null)
    {
        $data->editMode = true;
        config(['helper.data_edit' => $data]);
    }
}
if (! function_exists('admin_link')) {

    function admin_link($router = '', $withoutProject = FALSE)
    {

        return url(str_replace('//', '/', '/admin/' . $router));
    }
}
if (! function_exists('public_link')) {

    function public_link($router = '')
    {
        return url(str_replace('//', '/', '/' . $router));
    }
}
if (! function_exists('link_detail')) {

    function link_detail($item)
    {
        if (!isset($item['id'])) {
            return '';
        }
        if (!isset($item['alias'])) {
            $alias = \Libs::convertToAlias($item['title']);
        } else {
            $alias = $item['alias'];
        }

        return route('product.detail', ['alias' => $alias]);
    }
}
if (! function_exists('value_show')) {

    function value_show($value, $default = '')
    {
        if (is_string($value) || is_numeric($value)) {
            if(empty($value)){
                return $default;
            }
            return $value;
        }
        if(is_array($value)){
            if(isset($value['name']) && is_string($value['name'])){
                return $value['name'];
            }else if(isset($value['value']) && is_string($value['value'])){
                return $value['value'];
            }else{
                return $default;
            }
        }

        return $default;
    }
}

if (! function_exists('numberFormat')) {
    function numberFormat($stringNumber, $sep = '.')
    {
        // return $stringNumber;
        if(!$stringNumber){
            return $stringNumber;
        }
        return number_format($stringNumber, 0, '', $sep);
    }
}
