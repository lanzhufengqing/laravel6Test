<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function home(){
       // Auth::check() 判断是否已登录
        //phpinfo();
        return  view('static_pages/home');
    }

    public function help(){
        return  view('static_pages/help');

    }

    public function about(){
        return  view('static_pages/about');

    }
}
