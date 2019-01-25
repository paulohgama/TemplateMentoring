<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class CheckVisitante
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
        $user = Auth::user();
        try{
            if($user == null)
            {
                return redirect('/login');
            }
            else if($user->cd_role != 3) {
                return redirect('/')->with('permission', 'Você não tem permissão para acessar esta página');
            }
            else {
                return $next($request);
            }
        }
        catch(ErrorException $ex)
        {
            return redirect('/');
        }
    }
}
