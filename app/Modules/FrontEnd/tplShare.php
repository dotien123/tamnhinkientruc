<?php

use App\Models\Accessary;
use App\Models\Category;

\View::share('def', \Lib::tplShareGlobal());
\View::share('isHome', false);
\View::share('defLang', \Lib::getDefaultLang());
\View::share('menu', \Menu::getMenu(3));
\View::share('iconTop', \App\Models\Icon::getIcontop());
\View::share('iconBottom', \App\Models\Icon::getIconbottom());
// \View::share('brands', \App\Models\Brand::getBrand());
\View::share('cateService', \App\Models\Category::getCat(3));
\View::share('cateNo1', \App\Models\Product::getCateNo1());
\View::share('cateNo2', \App\Models\Product::getCateNo2());

\View::share('aces', \App\Models\Accessary::getCat());
\View::share('cateListSearch', \App\Models\Category::where([['status', 1], ['type', 1], ['pid', 0]])->orderBy('sort', 'ASC')->get());
\View::share('pureCates',Category::getPureCate());
\View::share('accessaryCates',Accessary::getCat());

\View::share('vehicle', \App\Models\Vehicles::getLiisVehicle());
\View::share('pricepk', \App\Models\ProductPrice::getlistPk());
\View::share('price', \App\Models\ProductPrice::getlist());
\View::share('payload', \App\Models\Payload::getlist());

\View::share('cateNews', \App\Models\Category::getCat(2));
\View::share('cateNewsIshome', \App\Models\Category::getCateNews());

\View::share('cateSibar', \App\Models\Category::where([['status', 1],['type', 1],['is_home',  1]])->take(8)->get());
\View::share('acess', \App\Models\Accessary::where([['status', 1]])->take(8)->get());
\View::share('brand', \App\Models\Brand::where('status', 1)->select('id', 'title', 'image')->get());
\View::share('lsCate', \App\Models\Category::getCatMenu(1));
\View::share('vechungtoi', App\Models\Page::where([['type', 1], ['status', 1]])->first());
\View::share('videoSibar', App\Models\Video::where('status', 1)->orderBy('id', 'DESC')->take(3)->get());
\View::share('keyApi' , 'AIzaSyB4OrsNwWyjA4Qkw-FEsqtbWZExMZa2QZo');
\View::share('lsSlide' , \App\Models\ConfigHome::get()->groupBy('type'));
\View::share('comment' , \App\Models\Page::where('status','>', '0')->where('type', '0')->get());
\View::share('banggia' , \App\Models\Page::where([['type', 2], ['status', 1]])->first());
$config = \App\Models\ConfigSite::getConfig('config', '');
\View::share('config', !empty($config) ? json_decode($config, true) : null);

\View::share('is_mobile', \App\Libs\Lib::mobile_device_detect());

