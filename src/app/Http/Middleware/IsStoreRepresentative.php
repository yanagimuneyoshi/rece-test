<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsStoreRepresentative
{
  public function handle($request, Closure $next)
  {
    if (Auth::check()) {
      if (Auth::user()->is_store_representative) {
        return $next($request);
      } else {
        Log::error('User is not store representative.', ['user_id' => Auth::id()]);
        abort(403, 'This action is unauthorized.');
      }
    } else {
      Log::error('User is not authenticated.');
      abort(403, 'This action is unauthorized.');
    }
  }
}
