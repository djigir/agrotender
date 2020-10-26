<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::redirect('/traders_sell', '/traders_sell/region_ukraine', 301);

/* routes for traders  */
Route::prefix('traders')
    ->name('traders.')
    ->group(function () {
        Route::redirect('/', '/traders/region_ukraine', 301);
        Route::redirect('/tport_producers', '/traders/region_ukraine', 301);
        Route::redirect('/tport_export/index', '/traders/region_ukraine', 301);
        Route::redirect('/tport_producers/index', '/traders/region_ukraine', 301);

        Route::get('/region_{region}', 'TraderController@index')->name('traders_regions');
        Route::get('/region_{region}/{culture}', 'TraderController@regionCulture')->name('traders_regions_culture');

        Route::get('/tport_{port_name}', 'TraderController@port')->name('traders_port');
        Route::get('/tport_{port}/{culture}', 'TraderController@portCulture')->name('traders_port_culture');

    });

/* routes for company  */
Route::prefix('kompanii')
    ->name('company.')
    ->group(function () {
        Route::get('/', 'CompanyController@companies')->name('companies');
        Route::get('/comp-{id_company}-prices', 'CompanyController@companyPrices')->name('company_prices');
        Route::get('/comp-{id_company}-cont', 'CompanyController@companyContact')->name('company_cont');
        Route::get('/comp-{id_company}-reviews', 'CompanyController@companyReviews')->name('company_reviews');
        Route::get('/comp-{id_company}-traderContacts', 'CompanyController@traderContacts')->name('trader_contacts');
        Route::get('/comp-{id_company}', 'CompanyController@company')->name('company');
        Route::get('/region_{region}', 'CompanyController@companyRegion')->name('company_and_region');
        Route::get('/s/{query}', 'CompanyController@companyFilter')->name('company_filter');
        Route::get('/region_{region}/t{rubric_number}', 'CompanyController@companyRegionRubric')->name('company_region_rubric_number');
    });


Route::get('/traders_forwards/region_{region}', 'TraderController@forwards')->name('traders_forwards');
Route::get('/traders_forwards/region_{region}/{culture}', 'TraderController@forwardsCulture')->name('traders_forwards_culture');
Route::get('/traders_sell/region_{region}', 'TraderController@sellRegion')->name('traders_sell');
Route::get('/traders_sell/region_{region}/{culture}', 'TraderController@sellCulture')->name('traders_sell_culture');

Route::get('/home', 'HomeController@index')->name('home');
