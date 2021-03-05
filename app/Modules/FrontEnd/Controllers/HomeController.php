<?php

namespace App\Modules\FrontEnd\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\Category;
use App\Models\ConfigSite;
use App\Models\Product;
use App\Models\PageIntro;
use App\Models\ServiceNew;
use App\Models\Feature;
use App\Models\Icon;
use App\Models\News;
use App\Models\Video;
use App\Models\IntroDetail;
use App\Models\Page;
use App\Models\Brand;
use GuzzleHttp\Psr7\Request;
use Youtube;

class HomeController extends Controller
{
    public function index(){
       
        ConfigSite::getSeo();
        $banner = Feature::where('status', '>','0')->get();

        return view('FrontEnd::pages.home.index',[ 'banner' => $banner, 'active'=>'home'] );
    }
  
}
