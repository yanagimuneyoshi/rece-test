<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminRegisterController extends Controller
{
    // 管理者用の登録フォームを表示
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    // 管理者登録処理
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // 管理者を新規作成
        $admin = $this->create($request->all());

        // ログイン状態にし、管理画面へリダイレクト
        auth()->login($admin);

        // 登録完了後に管理者ログイン画面にリダイレクト
        return redirect()->route('admin.login')->with('status', '登録が完了しました。ログインしてください。');
    
    }

    // 入力のバリデーション
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // 管理者を作成
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'admin', // 管理者として作成
        ]);
    }
}
