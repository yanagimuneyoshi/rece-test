<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    // 管理者用のログインフォーム表示
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // 管理者ログイン処理
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 管理者認証試行
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'])) {
            return redirect()->intended('/admin/dashboard'); // ログイン成功後のリダイレクト先
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが違います。',
        ]);
    }

    // 管理者ログアウト
    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
