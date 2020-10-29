<?php

namespace App\Http\Middleware;

use App\Models\Torg\TorgBuyer;
use Closure;
use Illuminate\Auth\Authenticatable;
use function Symfony\Component\String\s;


class CheckAuth
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
        /*if (!isset($_SESSION)){
            session_start();
        }
//        session_start();
        $user_id = $_SESSION['id'];
        $user = TorgBuyer::find($user_id);

//        app()->instance('user', $user);*/
        return $next($request);
    }
}
