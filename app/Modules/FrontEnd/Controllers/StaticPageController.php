<?php

namespace App\Modules\FrontEnd\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Comments;
use App\Models\Page;
use App\Models\ConfigSite;
use App\Models\Feature;
use App\Models\Comment;
use App\Models\Image;

use GuzzleHttp\Psr7\Request;

class StaticPageController extends Controller
{   //
    public function __construct(){

    }

    public function index(){
        $page = Page::where('status',1)->first();
        return view('FrontEnd::pages.page.index', [
            'page' => $page,
            'active' => 'about'
        ]);
       
    }

    public function awards()
    {
        $award = Image::where('status',1)->get();
        return view('FrontEnd::pages.page.awards', [
            'award' => $award,
            'active' => 'awards'
        ]);
    }
   
}
