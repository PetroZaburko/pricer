<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function (){
    Route::get('/', function () { return redirect()->route('categories.index');} );
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::resource('categories','CategoriesController', ['except'=> ['show', 'update', 'edit', 'create']]);
    Route::post('categories/upload', 'CategoriesController@upload')->name('categories.upload');
    Route::get('categories/{id}/history', 'CategoriesController@history')->name('categories.history');

    Route::get('adverts','AdvertsController@index')->name('adverts');
    Route::post('adverts','AdvertsController@save')->name('adverts.save');

    Route::resource('users', 'UsersController', ['only'=> ['index']]);
    Route::get('users/{id}/history', "UsersController@history")->name('users.history');
    Route::view('/users/settings', 'pages.settings')->name('users.settings');

    Route::get('history', 'HistoriesController@index')->name('history');
    Route::get('history/{id}/details', 'HistoriesController@details')->name('history.details');


    Route::resource('companies', 'CompaniesController', ['except' => ['show', 'edit', 'create', 'update']]);
    Route::get('companies/{id}', 'CompaniesController@company')->name('companies.company');
    Route::get('companies/{id}/status', 'CompaniesController@status')->name('companies.status');
});


Route::group(['middleware' => ['auth', 'isAdmin']], function (){
//    Route::resource('users', 'UsersController', ['only'=> ['edit', 'update']]);
//    delete users@edit after change edit form Auth user
//    Route::get('users/{id}/edit', 'UsersController@edit');
    Route::put('users/{id}/update', 'UsersController@update')->name('users.update');
    Route::post('/users/{id}/destroy', 'UsersController@delete')->name('users.delete');
    Route::get('users/{id}/status', 'UsersController@status')->name('users.status');
    Route::get('users/{id}/permissions', 'UsersController@permissions')->name('users.permissions');
    Route::post('categories/{id}/destroy','CategoriesController@delete')->name('categories.delete');
    Route::put('categories/{id}/update','CategoriesController@update')->name('categories.update');
    Route::put('companies/{id}/update', 'CompaniesController@update')->name('companies.update');

});


Route::group(['middleware' => 'guest'], function (){
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
});




//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
