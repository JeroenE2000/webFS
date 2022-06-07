<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CheckRole
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
        $roles = array_slice(func_get_args(), 2);

        $user = $request->user();
        if ($user != null) {
            foreach($roles as $role){
                if ($user->hasRole($role)) {
                    return $next($request);
                }
            }
        }
        return Redirect::to('/');
    }
}
