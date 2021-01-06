<?php

namespace App\Http\Controllers;

use App\Exports\CompItemsEmailsExport;
use App\Exports\PhoneExport;
use App\Exports\TorgBuyerExport;
use App\Models\Torg\TorgBuyer;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function loginAsUser(Request $request)
    {
        $user_id = $request->get('user_id');

        $user_old = TorgBuyer::find($user_id)->toArray();
        $user = User::firstOrCreate(['user_id' => $user_old['id']], $user_old);
        \auth()->login($user);
        return redirect()->route('company.companies');

    }

    public function downloadUsers(Request $request)
    {
        $users_id = '';
        return Excel::download(new TorgBuyerExport($users_id), 'users.csv');
    }

    public function downloadPhones()
    {
        return Excel::download(new PhoneExport(), 'all_phones.csv');
    }

    public function downloadCompanyEmails(Request $request)
    {
//        $link = \request()->server('REQUEST_URI');
//        $obl_id = mb_substr($link, 44, 2);
//        dd($obl_id);

        dd(__METHOD__, $request->all());
        $comp_id = '';
        return Excel::download(new CompItemsEmailsExport($comp_id), 'company_emails.csv');
    }

}
