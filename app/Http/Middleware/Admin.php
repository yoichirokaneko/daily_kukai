<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //ユーザーがログインしているかどうかをAuth::check()で確認。ログインしていてかつ、。admin==1の場合という条件になる
        if(Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }
        return redirect('home')->with('error', "You don't have admin access.");
    }
}
