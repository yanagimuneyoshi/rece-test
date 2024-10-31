<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // ログインユーザーが管理者であることを確認
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        // 管理者でない場合はホームページやエラーページにリダイレクト
        return redirect('/')->with('error', '管理者のみアクセス可能です。');
    }
}
