<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class CheckActiveSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    // cek status middleware (inline)
        if (Auth::user()->role !== 'seller' || Auth::user()->status !== 'active') {
            return redirect()->route('seller.status');
        }
        return $next($request);
    }
}
