<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\Admin;

class LoginController extends Controller
{

    public function getLogin()
    {
        return view('admin.login.login');
    }
    public function postLogin(Request $request)
    {
        $name=$request->name;
        $password=$request->password;
        // 尝试登录
        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            // 认证通过...
            return redirect('/index/index');
        }else{
            return back()->with('error','用户名或密码错误');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/login/login')->with('success','退出成功。');
    }
}
