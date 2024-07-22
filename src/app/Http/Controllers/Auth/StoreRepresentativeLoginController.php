<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StoreRepresentativeLoginController extends Controller
{
  public function showLoginForm()
  {
    return view('auth.store_representative_login');
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
      return redirect()->intended('/store/dashboard');
    }

    throw ValidationException::withMessages([
      'email' => [trans('auth.failed')],
    ]);
  }

  public function logout(Request $request)
  {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
  }
}
