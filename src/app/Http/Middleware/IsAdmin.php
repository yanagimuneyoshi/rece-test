<?php

// app/Http/Middleware/IsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
  public function handle($request, Closure $next)
  {
    if (Auth::check() && Auth::user()->is_admin) {
      return $next($request);
    }

    abort(403, 'This action is unauthorized.');
  }
}


