<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        // except 除了这些操作，其他操作必须登录用户才能访问
        $this->middleware('auth',[
            'except' => ['show','create','store']
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

    public function show(User $user)
    {

        return view('users.show',compact('user'));
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

        //注册后自动登录
        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',[$user]);
    }


    public function edit(User $user)
    {
         return view('users.edit', compact('user'));
    }

    public function update(User $user,Request $request)
    {
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


}
