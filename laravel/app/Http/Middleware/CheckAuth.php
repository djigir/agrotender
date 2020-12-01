<?php

namespace App\Http\Middleware;

use App\Models\Torg\TorgBuyer;
use App\Models\Users\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

        if (!isset($_SESSION)){
            session_start();

        }

        if(!isset($_SESSION['id'])){
            Auth::logout();
        }

        if($user_id){
            $user_old = TorgBuyer::find($user_id)->toArray();
            $user = User::firstOrCreate(['user_id' => $user_old['id']], $user_old);

            Auth::login($user);
        }


        return $next($request);
    }
}
