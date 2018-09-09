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

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



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
    Route::post('/admin/media/{id}/edit', 'MediaController@edit');
    Route::get('/admin/media/getImages', 'MediaController@getImages');

    Route::get('/admin/articles', 'PostController@index');
    Route::get('/admin/articles/new', 'PostController@newView');
    Route::post('/admin/articles/new', 'PostController@store');
    Route::get('/admin/articles/{id}/edit', 'PostController@editView');
    Route::post('/admin/articles/{id}/edit', 'PostController@edit');
    Route::post('/admin/articles/delete', 'PostController@delete');
    Route::post('/admin/articles/preview', 'PostController@preview');

    Route::get('/admin/articles/categories', 'CategoryController@index');
    Route::post('/admin/articles/categories', 'CategoryController@create');

    Route::get('/admin/articles/tags', 'TagController@index');
    Route::post('/admin/articles/tags', 'TagController@create');

    Route::get('/admin/pages', 'PageController@index');
    Route::get('/admin/pages/new', 'PageController@newView');
    Route::post('/admin/pages/new', 'PageController@create');
    Route::get('/admin/pages/permalink', 'PageController@permalink');
    Route::get('/admin/permissions', 'PermissionController@index');
    Route::post('/admin/permissions/', 'PermissionController@edit');

});

Route::post('/admin/login', 'Auth\LoginController@adminLogin');

Route::get('/', function () {
    return view('404');
});

Route::get('/preview/a', function () {

    $preview_post = Post::where('user_id', Auth::user()->id)->where('status', 'preview')->first();

    if ($preview_post)
        return view('article', ['item' => $preview_post]);
    else
        return view('404');
});

Route::get('/a/{slug}', function ($slug) {

    $item = \App\Post::where('slug', $slug)->first();

    if ($item)
        return view('article', ['item' => $item]);
    else
        return view('404');
});

Route::get('/{url}', function ($url) {

    App::setLocale('no');

    $page = \App\Page::where('permalink', $url)->first();

    if ($page)
        return view('welcome', ['item' => $page]);
    else
        return view('404');

})->where('url','.+');
