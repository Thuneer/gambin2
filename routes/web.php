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

    // USERS
    Route::get('/admin/users', 'UserController@index');
    Route::get('/admin/users/new', 'UserController@newView');
    Route::post('/admin/users/new', 'UserController@store');
    Route::get('/admin/users/{id}/edit', 'UserController@editView');
    Route::post('/admin/users/{id}/edit', 'UserController@edit');
    Route::post('/admin/users/delete', 'UserController@delete');

    // MEDIA
    Route::get('/admin/media', 'MediaController@index');
    Route::post('/admin/media', 'MediaController@upload');
    Route::post('/admin/media/delete', 'MediaController@delete');
    Route::post('/admin/media/{id}/edit', 'MediaController@edit');
    Route::get('/admin/media/getImages', 'MediaController@getImages');

    // ARTICLES
    Route::get('/admin/articles', 'PostController@index');
    Route::get('/admin/articles/new', 'PostController@newView');
    Route::post('/admin/articles/new', 'PostController@store');
    Route::get('/admin/articles/{id}/edit', 'PostController@editView');
    Route::post('/admin/articles/{id}/edit', 'PostController@edit');
    Route::post('/admin/articles/delete', 'PostController@delete');
    Route::get('/admin/articles/{amount}', 'PostController@getArticles');

    // CATEGORIES
    Route::get('/admin/articles/categories', 'CategoryController@index');
    Route::post('/admin/articles/categories', 'CategoryController@create');

    // TAGS
    Route::get('/admin/articles/tags', 'TagController@index');
    Route::post('/admin/articles/tags', 'TagController@create');

    // PAGES
    Route::get('/admin/pages', 'PageController@index');
    Route::get('/admin/pages/new', 'PageController@newView');
    Route::post('/admin/pages/new', 'PageController@create');
    Route::get('/admin/pages/{id}/edit', 'PageController@editView');
    Route::post('/admin/pages/{id}/edit', 'PageController@edit');
    Route::get('/admin/pages/permalink', 'PageController@permalink');
    Route::get('/admin/permissions', 'PermissionController@index');
    Route::post('/admin/permissions/', 'PermissionController@edit');

    // Messages
    Route::get('/admin/conversations', 'MessageController@index');
    Route::post('/admin/conversations', 'MessageController@newConversation');
    Route::get('/admin/conversations/{id}', 'MessageController@conversation');
    Route::post('/admin/conversations/{id}', 'MessageController@newMessage');

});

Route::get('/articles/{slug}', function ($slug) {

    $page = \App\Post::where('slug', $slug)->first();
    $articles = Post::where('id', '!=', $page->id)->take(6)->get();
    $title = 'Page not found';

    if ($page) {
        return view('article', ['item' => $page, 'articles' => $articles, 'title' => $title]);
    }
    else {
        return view('404', ['item' => $page, 'title' => $title]);
    }

});

Route::get('/', function () {

    $title = 'Page not found';

    if ($front_page = Page::where('front_page', '=', 1)->first()) {
        return view('welcome', ['item' => $front_page, 'title' => $title]);
    }
    return view('404', ['title' => $title]);

});

Route::get('/{url}', function ($url) {

    App::setLocale('no');
    $title = 'Page not found';

    $page = \App\Page::where('permalink', $url)->first();

    if ($page) {
        return view('welcome', ['item' => $page, 'title' => $title]);
    }
    else {
        return view('404', ['title' => $title]);
    }

})->where('url','.+');
