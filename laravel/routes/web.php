<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

/* routes for traders  */
Route::prefix('traders')
    ->name('traders.')
    ->group(function () {
        Route::get('/', 'TraderController@index');
        Route::get('/region_{region}', 'TraderController@region')->name('traders_regions');
        Route::get('/region_{region}/{culture}', 'TraderController@region_and_culture')->name('traders_regions_culture');
        Route::get('/tport_{port}/{culture}', 'TraderController@port_and_culture')->name('traders_port_culture');
        Route::get('/{port_name}', 'TraderController@port')->name('traders_port');
    });

Route::get('/traders_forwards/region_{region}', 'TraderController@forwards')->name('traders_forwards');
Route::get('/traders_sell', 'TraderController@sell_culture')->name('traders_forwards_culture');
Route::get('/traders_sell/region_{region}', 'TraderController@sell_culture')->name('traders_forwards_culture');
Route::get('/traders_forwards/region_{region}/{culture}', 'TraderController@forwards_culture')->name('traders_forwards_culture');
Route::get('/traders_sell/region_{region}/{culture}', 'TraderController@sell_culture')->name('traders_forwards_culture');



/* routes for company  */
Route::prefix('kompanii')
    ->name('company.')
    ->group(function () {
        Route::get('/', 'CompanyController@companies')->name('companies');
        Route::get('/comp-{id_company}-prices', 'CompanyController@company_prices')->name('company_prices');
        Route::get('/comp-{id_company}-cont', 'CompanyController@company_cont')->name('company_cont');
        Route::get('/comp-{id_company}-reviews', 'CompanyController@company_reviews')->name('company_reviews');
        Route::get('/comp-{id_company}-traderContacts', 'CompanyController@trader_contacts')->name('trader_contacts');
        Route::get('/comp-{id_company}', 'CompanyController@company')->name('company');
        Route::get('/region_{region}', 'CompanyController@company_and_region')->name('company_and_region');
        Route::get('/s/{query}', 'CompanyController@company_filter')->name('company_filter');
        Route::get('/region_{region}/t{rubric_number}', 'CompanyController@company_region_rubric_number')->name('company_region_rubric_number');
    });


Route::get('/home', 'HomeController@index')->name('home');

