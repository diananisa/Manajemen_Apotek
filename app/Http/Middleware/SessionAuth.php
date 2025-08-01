<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Cek login
        if (!Session::has('Username') || !Session::has('role')) {
            return redirect()->route('Login.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
