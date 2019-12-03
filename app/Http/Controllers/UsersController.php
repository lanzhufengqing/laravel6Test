<?php
/**
 * 用户注册、用户列表
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth; //用户认证 授权
use Mail; //发邮件

class UsersController extends Controller
{
    public function __construct()
    {
        // except 除了这些操作，其他操作必须登录用户才能访问,也就是未登录时可以访问的操作
        $this->middleware('auth',[
            'except' => ['show','create','store','index','confirmEmail']
            ]);
        //只允许未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //注册页面
    public function create()
    {
        return view('users.create');
    }

    /**
     * 用户详情页
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function show(User $user)
    {
        // 获取该用户的微博列表
        $statuses = $user->statuses()
                            ->orderBy('created_at','desc')
                            ->paginate(10);
        return view('users.show',compact('user','statuses'));
    }

    /**
     * 用户注册进库，并自动登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create
        ([
            'name' =>$request->name,
            'email' =>$request->email,
            'password' =>bcrypt($request->password),
        ]);

        //注册后自动登录改为邮箱激活才能登录
        //Auth::login($user);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success','验证邮件已发送到您的注册邮箱上，请注意查收。');
        return redirect('/');
        //return redirect()->route('users.show',[$user]);
    }


    public function edit(User $user)
    {
        //注册授权，验证当前登录用户不能修改访问其他用户的编辑资料页面，提示403权限不足
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user,Request $request)
    {
        //注册授权，验证当前登录用户不能提交其他用户的修改资料
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('users.show',$user);
        //return redirect()->route('users.show',$user->id); 同上一行
    }


    /**
     * 用户列表页
     * @return [type] [description]
     */
    public function index()
    {
        //取出全部用户
        //$users = User::all();
        $users =User::paginate(10); //分页取数据 每页10条
        return view('users.index',compact('users'));
    }


    public function destroy(User $user)
    {
        //增加删除授权策略
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除用户');
        // 刷新当前页面
        return back();
    }

    /**
     * 发送邮箱
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        //$from $name 是本地调试使用
        // $from = 'lanzhufengqing@126.com';
        // $name = 'guowh';
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            // $message->from($from, $name)->to($to)->subject($subject);
            $message->to($to)->subject($subject);//$from $name的配置值在.env文件中
        });
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail(); //查询不到时返回404

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success','恭喜您，激活成功！');
        return redirect()->route('users.show',[$user]);
    }


}
