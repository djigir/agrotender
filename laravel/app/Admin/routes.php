<?php

use Illuminate\Support\Facades\Route;

Route::get('', ['as' => 'admin.dashboard', function () {
	$content = 'Define your dashboard here.';
	return AdminSection::view($content, 'Dashboard');
}]);

Route::get('information', ['as' => 'admin.information', function () {
	$content = 'Define your information here.';
	return AdminSection::view($content, 'Information');
}]);

Route::get('/login_as_user', [
    'as' => 'admin.login_as_user',
    'uses' => '\App\Http\Controllers\UserController@profile',
//    'middleware' => 'check_auth'
]);
