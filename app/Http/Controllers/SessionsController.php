<?php
/**
 * 用户登录、退出会话
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //用户登录页
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 保存登录会话
     * @return [type] [description]
     */
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

        //登录时选中记住我，选中后记住五年
        if (Auth::attempt($credentials,$request->has('remember'))) {
           session()->flash('success', '欢迎回来！');
           return redirect()->route('users.show', [Auth::user()]);
       } else {
           session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
           return redirect()->back()->withInput();
       }

    }

    /**
     * 退出登录，销毁会话
     * @return [type] [description]
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出!');
        return redirect()->route('login');
    }


}
