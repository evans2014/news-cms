<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //dd('AdminMiddleware works!', $request->user());

        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Нямате достъп!');
        }

        return $next($request);
    }

}