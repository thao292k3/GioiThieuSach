<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AccountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,  $role): Response
    {

        if (Auth::check() && Auth::user()->role == 1) {  // 1 là admin
            return $next($request);
        }

        return redirect()->route('home')->with('No', 'Bạn không có quyền truy cập vào trang này');
    }
}