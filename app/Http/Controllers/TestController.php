<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index(Request $request,$arg2,$arg1){
        echo $arg2;
        echo $arg1;
    }

	
}