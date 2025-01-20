<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\AuthAdmin;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
             
            if(Auth::user()->utype==='user')
            {
                return $next($request);

            }elseif(Auth::user()->utype==='admin')
            {
                return $next($request);
            }
            else{
                Session:flush();
                return redirect()->route('login');
            }

        } else{
            
            return redirect()->route('login');
        }


        
    }
}
