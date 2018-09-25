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

use App\Page;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


// Authentication Routes...
Route::post('admin/login', 'Auth\LoginController@login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/admin/login', function () {

    if (Auth::check() && Auth::user()->hasRoles('access admin')) {
        return redirect('admin');
    }

    return view('admin/login');

});

Route::post('/admin/login', 'Auth\LoginController@adminLogin');

Route::group(['middleware' => ['admin']], function () {

    Route::get('/admin', function () {

        $users = User::take(5)->get();
        $articles = Post::take(5)->get();
        $pages = Page::take(7)->get();

        return view('admin/home', compact('users', 'articles', 'pages'));

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
    Route::get('/admin/articles/{amount}', 'PostController@getArticles');

    Route::get('/admin/articles/categories', 'CategoryController@index');
    Route::post('/admin/articles/categories', 'CategoryController@create');

    Route::get('/admin/articles/tags', 'TagController@index');
    Route::post('/admin/articles/tags', 'TagController@create');

    Route::get('/admin/pages', 'PageController@index');
    Route::get('/admin/pages/new', 'PageController@newView');
    Route::post('/admin/pages/new', 'PageController@create');
    Route::get('/admin/pages/{id}/edit', 'PageController@editView');
    Route::post('/admin/pages/{id}/edit', 'PageController@edit');
    Route::get('/admin/pages/permalink', 'PageController@permalink');
    Route::get('/admin/permissions', 'PermissionController@index');
    Route::post('/admin/permissions/', 'PermissionController@edit');

});

Route::get('/preview/a', function () {

    $preview_post = Post::where('user_id', Auth::user()->id)->where('status', 'preview')->first();

    if ($preview_post) {
        return view('article', ['item' => $preview_post]);
    }
    else {
        $page = new stdClass();
        $page->title = 'Page not found';
        return view('404', ['item' => $page]);
    }

});

Route::get('/articles/{slug}', function ($slug) {

    $page = \App\Post::where('slug', $slug)->first();
    $articles = Post::where('id', '!=', $page->id)->take(6)->get();

    if ($page) {
        return view('article', ['item' => $page, 'articles' => $articles]);
    }
    else {
        $page = new stdClass();
        $page->title = 'Page not found';
        return view('404', ['item' => $page]);
    }

});

Route::get('/', function () {

    if ($front_page = Page::where('front_page', '=', 1)->first()) {
        return view('welcome', ['item' => $front_page]);
    }

    $page = new stdClass();
    $page->title = 'Page not found';
    return view('404', ['item' => $page]);

});

Route::get('/{url}', function ($url) {

    App::setLocale('no');

    $page = \App\Page::where('permalink', $url)->first();

    if ($page) {
        return view('welcome', ['item' => $page]);
    }
    else {
        $page = new stdClass();
        $page->title = 'Page not found';
        return view('404', ['item' => $page]);
    }

})->where('url','.+');
