<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class isAdmin
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
        if(Auth::user()->is_admin or Auth::id() == $request->id){
            return $next($request);
        }
        return redirect()->back()->with([
            'message'=> 'You don\'t have enough permissions',
            'status' => 0
        ]);
    }
}
