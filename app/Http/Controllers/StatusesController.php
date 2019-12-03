<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        //只有登录用户才能访问该类中的方法
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'content'   =>  'required|max:140'
        ]);

        // Auth::user 获取当前用户，及当前用户发布微博
        Auth::user()->statuses()->create([
            'content'   =>  $request['content']
            ]);
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }
}
