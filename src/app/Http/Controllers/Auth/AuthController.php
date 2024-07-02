<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function showRegisterForm()
  {
    return view('auth.register');
  }

  public function processRegister(RegisterUserRequest $request)
  {
    $user = User::create([
      'name' => $request->username,
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);

    Auth::login($user);

    return redirect('/thanks');
  }

  public function login()
  {
    return view('auth.login');
  }

  public function processLogin(LoginUserRequest $request)
  {
    $email = $request->input('email');
    $password = $request->input('password');

    if (Auth::attempt(['email' => $email, 'password' => $password])) {
      return redirect('/menu1');
    } else {
      return back()->withErrors(['login_error' => 'メールアドレスまたはパスワードが違います。']);
    }
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
  }
}
