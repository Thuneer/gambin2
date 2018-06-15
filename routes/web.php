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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/admin/login', function () {

    return view('admin/login');

});


Route::group(['middleware' => ['canAccessAdmin']], function () {



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
    Route::get('/admin/media/getImages', function (Request  $request) {

        $search = $request->input( 'search' );

        if (strlen($search) !== 0) {
            $media = \App\Media::where('name', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'DESC')->get();
        } else {
            $media = \App\Media::orderBy('created_at', 'DESC')->take(32)->get();
        }


        return response()->json($media);

    });



});

Route::post('/admin/login', 'Auth\LoginController@adminLogin');

