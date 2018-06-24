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

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/admin/login', function () {

    if (Auth::check() && Auth::user()->hasRoles('access admin')) {
        return redirect('admin');
    }

    return view('admin/login');

});


Route::group(['middleware' => ['admin']], function () {



    Route::get('/admin', function () {

        return view('admin/home');

    });

    Route::get('/admin/users', 'UserController@index');
    Route::get('/admin/users/new', 'UserController@newView');
    Route::post('/admin/users/new', 'UserController@store');
    Route::get('/admin/users/{id}/edit', 'UserController@editView');
    Route::post('/admin/users/{id}/edit', 'UserController@edit');
    Route::post('/admin/users/delete', 'UserController@delete');

    Route::get('/admin/media', 'MediaController@index');
    Route::post('/admin/media', 'MediaController@upload');
    Route::post('/admin/media/delete', 'MediaController@delete');
    Route::get('/admin/media/{id}/edit', 'MediaController@editView');
    Route::post('/admin/media/{id}/edit', 'MediaController@edit');
    Route::get('/admin/media/getImages', 'MediaController@getImages');

    Route::get('/admin/articles', 'PostController@index');
    Route::get('/admin/articles/new', 'PostController@newView');
    Route::post('/admin/articles/new', 'PostController@store');
    Route::get('/admin/articles/{id}/edit', 'PostController@editView');
    Route::post('/admin/articles/{id}/edit', 'PostController@edit');
    Route::post('/admin/articles/delete', 'PostController@delete');


    Route::get('/admin/permissions', 'PermissionController@index');

    Route::post('/admin/permissions/', 'PermissionController@edit');

});

Route::post('/admin/login', 'Auth\LoginController@adminLogin');

