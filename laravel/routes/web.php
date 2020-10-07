<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

/* routes for traders  */
Route::prefix('traders')
    ->name('traders.')
    ->group(function () {

        Route::get('/', function () {
            return redirect('/traders/region_ukraine');
        });
        Route::get('/region_{region}', 'TraderController@region')->name('traders_regions');
        Route::get('/region_{region}/{culture}', 'TraderController@region_and_culture')->name('traders_regions_culture');
    });

//Route::post('/buyerreg', function () {
//    return view('auth.register');
//})->name('sing-up');
//Route::get('/buyerlog', 'UserController@sing_in')->name('sing-in');

/* routes for company  */
Route::prefix('kompanii')
    ->name('company.')
    ->group(function () {
        Route::get('/', 'CompanyController@all_company')->name('all_company');
        Route::get('/comp-{id_company}-prices', 'CompanyController@company_prices')->name('company_prices');
        Route::get('/comp-{id_company}-reviews', 'CompanyController@company_reviews')->name('company_reviews');
        Route::get('/comp-{id_company}-cont', 'CompanyController@company_cont')->name('company_cont');
        Route::get('/comp-{id_company}', 'CompanyController@company_id')->name('company_id');
        Route::get('/region_{region}', 'CompanyController@company_and_region')->name('company_and_region');
        Route::get('/s/{query}', 'CompanyController@company_filter')->name('company_filter');
        Route::get('/region_{region}/t{rubric_number}', 'CompanyController@company_region_rubric_number')->name('company_region_rubric_number');

    });



Route::get('/home', 'HomeController@index')->name('home');
