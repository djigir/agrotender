<?php

namespace App\Http\Controllers;

use App\Models\Torg\TorgBuyer;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginAsUser(Request $request)
    {
//        dd(__METHOD__, $request->all());
        $user_id = $request->get('user_id');

        $user_old = TorgBuyer::find($user_id)->toArray();
        $user = User::firstOrCreate(['user_id' => $user_old['id']], $user_old);
        \auth()->login($user);
        return redirect()->route('company.companies');

    }

}
