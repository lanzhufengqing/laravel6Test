<?php
/**
 * 用户登录、退出会话
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{

    public function __construct()
    {
        //guest 只允许游客（未登录）用户访问登录页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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
            if(Auth::user()->activated){//用户已激活
                session()->flash('success', '欢迎回来！');
                //$fallback = route('users.show', [Auth::user()]);
                //登录成功后跳转到上次尝试打开页面，没有的话默认跳转到users.show
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            }else{//未激活，退出登录认证 返回首页
                Auth::logout();
                session()->flash('warning', '您的账号未激活，请检查邮箱中的注册邮件进行激活');
                return redirect('/');
            }


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
