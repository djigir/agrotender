<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::any('/test','TestController@index')->name('test');
Route::get('/home', 'HomeController@index')->name('home');
//Auth::routes();

Route::redirect('/traders_sell', '/traders_sell/region_ukraine', 301);


/* Admins routes */
Route::get('/admin_dev/delete_traders', 'TraderController@deleteAdmin')->name('delete_traders_admin');
/* */

/* routes for traders  */
Route::prefix('admin_dev')
    ->name('admin.')
    ->group(function () {
        Route::get('/download_users', 'AdminController@downloadUsers')->name('download_users');
        Route::get('/download_phones', 'AdminController@downloadPhones')->name('download_phones');
        Route::get('/download_company_emails', 'AdminController@downloadCompanyEmails')->name('download_company_emails');
    });

/* routes for traders  */
Route::prefix('traders')
    ->name('traders.')
    ->group(function () {
        Route::redirect('/', '/traders/region_ukraine', 301);
        Route::redirect('/tport_producers', '/traders/region_ukraine', 301);
        Route::redirect('/tport_export', '/traders/region_ukraine', 301);
        Route::redirect('/tport_export/index', '/traders/region_ukraine', 301);
        Route::redirect('/tport_producers/index', '/traders/region_ukraine', 301);
        Route::redirect('/tport_tradecomps', '/traders/region_ukraine', 301);
        Route::redirect('/tport_tradecomps/index', '/traders/region_ukraine', 301);

        Route::get('/region_{region}', 'TraderController@index')->name('region');
        Route::get('/region_{region}/{culture}', 'TraderController@regionCulture')->name('region_culture');

        Route::get('/get_traders_card', 'TraderController@addTradersCard')->name('get_traders_card');
        Route::get('/get_traders_table', 'TraderController@addTradersTable')->name('get_traders_table');

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
        Route::get('/comp-{id_company}-adverts', 'CompanyController@companyAdverts')->name('adverts');
        Route::get('/comp-{id_company}-traderContacts', 'CompanyController@traderContacts')->name('trader_contacts');
        Route::get('/comp-{id_company}', 'CompanyController@company')->name('index');
        Route::post('/create_review/{id_company}', 'CompanyController@createReviews')->name('create_review');
    });


//Route::prefix('info')
//    ->name('info.')
//    ->group(function () {
//        Route::get('/orfeta', 'InfoController@companies')->name('orfeta');
//        Route::get('/limit_adv', 'InfoController@companies')->name('limit_adv');
//        Route::get('/contacts', 'InfoController@companies')->name('contacts');
//});


Route::prefix('u')
    ->name('user.')
    ->group(function () {
        Route::prefix('/')
            ->middleware('check_auth_user')
            ->name('profile.')
            ->group(function () {
                Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
                Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
                Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
                Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

                Route::get('/company', 'UserController@profileCompany')->name('company');
                Route::get('/', 'UserController@profile')->name('profile');
                Route::get('/contacts', 'UserController@profileContacts')->name('contacts');
                Route::get('/notify', 'UserController@profileNotify')->name('notify');
                Route::get('/reviews', 'UserController@profileReviews')->name('reviews');
                Route::get('/news', 'UserController@profileNews')->name('news');
                Route::get('/vacancy', 'UserController@profileVacancy')->name('vacancy');

                Route::post('/create_company', 'UserController@createCompanyProfile')->name('create_company');
                Route::post('/change_pass', 'UserController@changePass')->name('change_pass');
                Route::post('/change_login', 'UserController@changeLogin')->name('change_login');
                Route::post('/toggle_visible', 'UserController@toggleVisible')->name('toggle_visible');
                Route::post('/create_contacts', 'UserController@createContacts')->name('create_contacts');
                Route::post('/change_contacts', 'UserController@changeContacts')->name('change_contacts');

                Route::post('/action_news', 'UserController@actionNews')->name('action_news');
                Route::post('/edit_news', 'UserController@editNews')->name('edit_news');
                Route::post('/print_news', 'UserController@printNews')->name('print_news');
                Route::get('/delete_news', 'UserController@deleteNews')->name('delete_news');
                Route::post('/create_vacancy', 'UserController@createVacancy')->name('create_vacancy');
                Route::post('/print_vacancy', 'UserController@printVacancy')->name('print_vacancy');
//                Route::post('/edit_vacancy', 'UserController@editVacancy')->name('edit_vacancy');
                Route::get('/edit_vacancy', 'UserController@editVacancy')->name('edit_vacancy');
                Route::get('/delete_vacancy', 'UserController@deleteVacancy')->name('delete_vacancy');

                Route::get('/reset_email', 'UserController@emailChangeLink')->name('change_email');
                Route::get('/success', 'UserController@emailVerification')->name('success');
                Route::get('/email_changed', 'UserController@successEmailChanged')->name('email_changed');

            });

        Route::prefix('/posts')
            ->name('advert.')
            ->group(function () {
                Route::get('/', 'UserController@advert')->name('advert');
                Route::get('/limits', 'UserController@advertLimit')->name('limit');
                Route::get('/upgrade', 'UserController@advertUpgrade')->name('upgrade');
        });

        Route::prefix('/balance')
            ->name('tariff.')
            ->group(function () {
                Route::get('/pay', 'UserController@balancePay')->name('pay');
                Route::get('/history', 'UserController@balanceHistory')->name('history');
                Route::get('/docs', 'UserController@balanceDocs')->name('docs');
        });

        Route::get('/proposeds', 'UserController@application')->name('application');
});


Route::prefix('elev')
    ->name('elev.')
    ->group(function () {
        Route::get('/', 'EvelatorController@elevators')->name('elevators');
        Route::get('/{region}', 'EvelatorController@elevatorsRegion')->name('region')->where('region', '[A-Za-z]+');
        Route::get('/{url}', 'EvelatorController@elevator')->name('elevator');

});



