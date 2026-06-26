<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && in_array(strtolower(Auth::user()->role), ['pemilik', 'owner'])) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
