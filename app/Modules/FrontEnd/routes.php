<?php
Route::group(
    [
        'module' => 'FrontEnd',
        'namespace'=>'App\Modules\FrontEnd\Controllers',
        'middleware' => ['web']
    ],
    function(){
        //site map
        Route::get('sitemap_generator', 'SiteMapController@index');
        Route::get('/clear-cache', function() {
            $exitCode = \Illuminate\Support\Facades\Artisan::call('cache:clear');
            // return what you want
            echo $exitCode;
            echo 'Clear Done!';
        });
        //Clear Config cache:
        Route::get('/config-cache', function() {
            $exitCode = \Illuminate\Support\Facades\Artisan::call('config:cache');
            return '<h1>Clear Config cleared</h1>';
        });
        //for ajax
        Route::any('ajax/{cmd}', [ 'as' => 'ajax', 'uses' => 'AjaxController@init']);
        
        // Route::get('captcha-form', 'CaptchaController@captchForm');
        // Route::post('store-captcha-form', 'CaptchaController@storeCaptchaForm');
        
        //home
        Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
        
        Route::get('/lien-he-m{id}', ['as' => 'contact.index', 'uses' => 'ContactController@index']);
        

        //tin tức
        Route::group(['as' => 'news.', 'prefix' => ''], function() {
            Route::get('/news', ['as' => 'list', 'uses' => 'NewsController@index']);

            // Route::any('/{alias}-n-m{id}', ['as' => 'detail', 'uses' => 'NewsController@detail'])
            //     ->where([
            //         'alias' => '[a-zA-Z0-9_\-]+',
            //         'id' => '[0-9_\-]+',
            //     ]);

            // Route::any('/{alias}-nw{id}', ['as' => 'new', 'uses' => 'NewsController@newCate'])
            // ->where([
            //     'alias' => '[a-zA-Z0-9_\-]+',
            //     'id' => '[0-9_\-]+',
            // ]);
        });

        // Sản phẩm
        Route::group(['as' => 'project.', 'prefix' => ''], function() {
            Route::any('/list', ['as' => 'list', 'uses' => 'ProductController@index']);
            Route::any('/calldatacate', ['as' => 'calldatacate', 'uses' => 'ProductController@getCateData']);
            Route::any('/loadmore', ['as' => 'loadmore', 'uses' => 'ProductController@loadmore']);

            
            // Route::any('/san-pham-noi-bat-m{id}', ['as' => 'higlight', 'uses' => 'ProductController@higlight'])->where([
            //     'id' => '[0-9_\-]+',
            // ]);
            
            // Route::any('/{alias}-c{id}', ['as' => 'storyCate', 'uses' => 'ProductController@storyCate'])->where([
            //     'id' => '[0-9_\-]+',
            //     'alias' => '[a-zA-Z0-9_\-]+',
            // ]);

            // Route::any('/phu-kien{id}', ['as' => 'ace', 'uses' => 'ProductController@ACE'])->where([
            //     'id' => '[0-9_\-]+',
            // ]);

            // Route::any('/{alias}-cb{id}', ['as' => 'ace', 'uses' => 'ProductController@CateChil'])->where([
            //     'id' => '[0-9_\-]+',
            //     'alias' => '[a-zA-Z0-9_\-]+',
            // ]);
            
            Route::any('/{alias}-p{id}.html', ['as' => 'detail', 'uses' => 'ProductController@detail'])
                ->where([
                    'id' => '[0-9_\-]+',
                    'alias' => '[a-zA-Z0-9_\-]+',
                ]);

            // Route::post('/comment', ['as' => 'comment', 'uses' => 'ProductController@comment']);

        });

        //Page static
        Route::group(['as' => 'page.' , 'prefix' => ''] , function (){
            Route::get('/about' , ['as' => 'index' , 'uses' => 'StaticPageController@index'])
                ->where([
                    'alias' => '[a-zA-Z0-9_\-]+',
                ]);
        });

        Route::get('/awards' , ['as' => 'awards' , 'uses' => 'StaticPageController@awards']);
        Route::get('/people' , ['as' => 'peole' , 'uses' => 'IntroduceController@index']);

        
        

        //Route::get('email/{tpl}', ['as' => 'email', 'uses' => 'EmailController@showEmailTemplate']);

        //set language
        //Route::get('language/{lang}', ['as' => 'language', 'uses' => 'LanguageController@change']);
        //Route::get('js/lang.js', ['as' => 'assets.lang', 'uses' => 'LanguageController@getJson']);

        //error
        Route::get('404', function () {
            return abort(404);
        });
        Route::get('500', function () {
            return abort(500);
        });

    }
);

