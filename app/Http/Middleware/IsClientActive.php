<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsclientActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(isset(auth()->user()->status)){
            if(auth()->user()->status == 1){
                return $next($request);
            }
        }

        return redirect()->route('client.home');
    }
}