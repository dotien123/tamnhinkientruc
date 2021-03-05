<?php


namespace App\Modules\Mobile\Controllers;


use App\Http\Controllers\Controller;
use App\Models\News;

class JourneysController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $pagi = 6;
        $data = [];
        return view('Mobile::pages.journeys.index', [
            'site_title' => 'Hành trình cotarin',
            'data' => $data,
        ]);
    }
    
    public function glycemic(){
        $pagi = 6;
        $data = [];
        return view('Mobile::pages.journeys.history', [
            'site_title' => 'Hành trình đường huyết',
            'data' => $data,
            'news' => News::getAllNews(),
        ]);
    }
}