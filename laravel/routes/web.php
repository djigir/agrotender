<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/home', 'HomeController@index')->name('home');
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

        Route::get('/region_{region}', 'TraderController@index')->name('region');
        Route::get('/region_{region}/{culture}', 'TraderController@regionCulture')->name('region_culture');

        Route::get('/tport_{port_name}', 'TraderController@port')->name('port');
        Route::get('/tport_{port}/{culture}', 'TraderController@portCulture')->name('port_culture');

    });


/* routes for traders forwards  */
Route::prefix('traders_forwards')
    ->name('traders_forward.')
    ->group(function (){
        Route::get('/region_{region}', 'TraderController@forwardsRegion')->name('region');
        Route::get('/region_{region}/{culture}', 'TraderController@forwardsRegionCulture')->name('region_culture');

        Route::get('/tport_{port}', 'TraderController@forwardsPort')->name('port');
        Route::get('/tport_{port}/{culture}', 'TraderController@forwardsPortCulture')->name('port_culture');
    });


/* routes for traders sell  */
Route::prefix('traders_sell')
    ->name('traders_sell.')
    ->group(function (){
        Route::get('/region_{region}', 'TraderController@sellRegion')->name('region');
        Route::get('/region_{region}/{culture}', 'TraderController@sellRegionCulture')->name('region_culture');

        Route::get('/tport_{port}', 'TraderController@sellPort')->name('port');
        Route::get('/tport_{port}/{culture}', 'TraderController@sellPortCulture')->name('port_culture');
    });


/* routes for company */
Route::prefix('kompanii')
    ->name('company.')
    ->group(function () {
        Route::get('/', 'CompanyController@companies')->name('companies');
        Route::get('/region_{region}', 'CompanyController@companiesRegion')->name('region');
        Route::get('/s/{query}', 'CompanyController@companiesFilter')->name('filter');
        Route::get('/region_{region}/t{rubric_number}', 'CompanyController@companiesRegionRubric')->name('region_culture');

        Route::get('/comp-{id_company}-prices', 'CompanyController@companyPrices')->name('prices');
        Route::get('/comp-{id_company}-cont', 'CompanyController@companyContact')->name('cont');
        Route::get('/comp-{id_company}-reviews', 'CompanyController@companyReviews')->name('reviews');
        Route::get('/comp-{id_company}-forwards', 'CompanyController@companyForwards')->name('forwards');
        Route::get('/comp-{id_company}-traderContacts', 'CompanyController@traderContacts')->name('trader_contacts');
        Route::get('/comp-{id_company}', 'CompanyController@company')->name('index');
        Route::post('/create_review/{id_company}', 'CompanyController@createReviews')->name('create_review');
    });


Route::prefix('info')
    ->name('info.')
    ->group(function () {
        Route::get('/orfeta', 'InfoController@companies')->name('orfeta');
        Route::get('/limit_adv', 'InfoController@companies')->name('limit_adv');
        Route::get('/contacts', 'InfoController@companies')->name('contacts');
});


Route::prefix('elev')
    ->name('elev.')
    ->group(function () {
        Route::get('/', 'EvelatorController@elevators')->name('elevators');
        Route::get('/{region}', 'EvelatorController@elevatorsRegion')->name('region');
        Route::get('/{url}', 'EvelatorController@elevator')->name('elevator');
});

