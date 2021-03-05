<?php
if (config('debugbar.enabled')) {
    \Illuminate\Support\Facades\DB::connection()->enableQueryLog();
}
Route::get('/', [ 'as' => 'admin.checkAuthNow', 'uses' => 'App\Modules\BackEnd\Controllers\HomeController@checkAuth']);
Route::group(['as' => 'product.', 'prefix' => 'san-pham'], function() {
    Route::get('{alias}', ['as' => 'detail', 'uses' => 'App\Modules\FrontEnd\Controllers\ProductController@detail'])->where(['alias' => '[a-zA-Z0-9_\-]+']);
});
//Route::group(['as' => 'news.', 'prefix' => ''], function() {
//    //News
//    Route::get('{alias}', ['as' => 'detail', 'uses' => 'App\Modules\FrontEnd\Controllers\NewsController@detail'])
//        ->where(['alias' => '[a-zA-Z0-9_\-]+']);
//});
Route::group(
    [
        'prefix' => 'admin',
        'module' => 'BackEnd',
        'namespace'=>'App\Modules\BackEnd\Controllers',
        'middleware' => ['web']
    ],
    function(){
        //login
        Auth::routes();
        Route::get('logout', [ 'as' => 'logout', 'uses' => '\App\Modules\BackEnd\Controllers\Auth\LoginController@logout']);
        Route::get('register/success', [ 'as' => 'register.success', 'uses' => '\App\Modules\BackEnd\Controllers\Auth\RegisterController@success']);

        /**  page - admin **/
        Route::group(['middleware' => ['auth']], function (){
            //home page
            Route::get('home', [ 'as' => 'admin.home', 'uses' => 'HomeController@index']);

            $basicGroup = config('permission');
            foreach ($basicGroup['backend'] as $key => $value){
                $prefixController = $value['controller'];
                Route::any('ajax/'.$key.'/{cmd}', ['as' => 'admin.'.$key.'ajax', 'uses' => $prefixController.'Controller@ajax']);

                $perms = isset($value['perm']) ? $value['perm'] : \App\Models\Role::$defRoles;
                if(count($perms) == 1 && isset($value['form']) && $value['form'] == 1){
                    foreach ($perms as $perm => $perm_title) {
                        Route::get($key, ['as' => 'admin.' . $key, 'uses' => $prefixController . 'Controller@index'])->middleware('can:' . $key . '-'.$perm.',App\Models\Role::' . $key . '-'.$perm);
                        Route::post($key, ['as' => 'admin.' . $key . '.post', 'uses' => $prefixController . 'Controller@submit'])->middleware('can:' . $key . '-'.$perm.',App\Models\Role::' . $key . '-'.$perm);
                        break;
                    }
                }else{
                    \Lib::set('route', [$key, $prefixController, $perms]);
                    Route::group(['prefix' => $key, 'middleware' => 'can:'.$key.'-view,App\Models\Role::'.$key.'-view'], function() {
                        $key = \Lib::get('route')[0];
                        $prefixController = \Lib::get('route')[1];
                        $perms = \Lib::get('route')[2];
                        foreach ($perms as $perm => $perm_title) {
                            switch ($perm){
                                
                                case 'view':
                                    Route::any('/', ['as' => 'admin.'.$key, 'uses' => $prefixController.'Controller@index']);
                                    break;
                                case 'add':
                                    Route::get('add', [ 'as' => 'admin.'.$key.'.add', 'uses' => $prefixController.'Controller@showAddForm'])
                                        ->middleware('can:'.$key.'-add,App\Models\Role::'.$key.'-add');
                                    Route::post('add', [ 'as' => 'admin.'.$key.'.add.post', 'uses' => $prefixController.'Controller@save'])
                                        ->middleware('can:'.$key.'-add,App\Models\Role::'.$key.'-add');
                                    break;
                                case 'edit':
                                    Route::get('edit/{id}', [ 'as' => 'admin.'.$key.'.edit', 'uses' => $prefixController.'Controller@showEditForm'])
                                        ->middleware('can:'.$key.'-edit,App\Models\Role::'.$key.'-edit');
                                    Route::post('edit/{id}', [ 'as' => 'admin.'.$key.'.edit.post', 'uses' => $prefixController.'Controller@save'])
                                        ->middleware('can:'.$key.'-edit,App\Models\Role::'.$key.'-edit');
                                    break;
                                case 'delete':
                                    Route::get('delete/{id}', [ 'as' => 'admin.'.$key.'.delete', 'uses' => $prefixController.'Controller@delete'])
                                        ->middleware('can:'.$key.'-delete,App\Models\Role::'.$key.'-delete');
                                    break;
                            }
                        }
                        //mo rong cac form dac biet
                        switch ($key){
                            case 'user':
                                Route::any('log/{id}', ['as' => 'admin.'.$key.'.log', 'uses' => $prefixController.'Controller@log']);
                                Route::get('profile', ['as' => 'admin.'.$key.'.profile', 'uses' => $prefixController.'Controller@showProfileForm']);
                                Route::post('profile', ['as' => 'admin.'.$key.'.profile.post', 'uses' => $prefixController.'Controller@updateProfile']);
                                Route::post('information/{id}', ['as' => 'admin.'.$key.'.edit.information', 'uses' => $prefixController.'Controller@updateInfomation']);
                                break;
                            case 'coupon':
                                Route::post('coupon/import', ['as' => 'admin.'.$key.'.import.post', 'uses' => $prefixController.'Controller@import']);
//                                    ->middleware('can:'.$key.'-coupon_sys,App\Models\Role::'.$key.'-add');
                                Route::post('coupon/save', ['as' => 'admin.'.$key.'.save.post', 'uses' => $prefixController.'Controller@saveAjax']);
                                break;
                            case 'order':
                                Route::any('log/{id}', ['as' => 'admin.'.$key.'.log', 'uses' => $prefixController.'Controller@log']);
                                break;
                        }
                    });
                }
            }
        });
    }
);