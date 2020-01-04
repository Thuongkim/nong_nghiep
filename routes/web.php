<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
|
| Cach dat ten
| admin.login, home -> bo qua, moi admin deu co quyen truy nhap
| admin.__module__.__action__ -> phan quyen
*/
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'as' => 'admin.'], function() {
    Route::get('login', array('as' => 'login', 'uses' => 'HomeController@getLogin'));
    Route::group(array('before' => 'csrf'), function() {
        Route::post('login', array('as' => 'login', 'uses' => "HomeController@postLogin"));
    });

    Route::group(array('middleware' => 'admin'), function() {
        Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
        Route::get('huong-dan/{slug}', ['as' => 'static', 'uses' => 'HomeController@staticPage']);
        Route::get('403', array('as' => '403', 'uses' => 'HomeController@get403'));
        Route::get('404', array('as' => '404', 'uses' => 'HomeController@get404'));
        Route::get('/logout', array('as' => 'logout', 'uses' => "HomeController@getLogout"));
        Route::get('/change-password', array('as' => 'change-password', 'uses' => 'HomeController@changePassword'));
        Route::post('/change-password', array('as' => 'change-password', 'uses' => 'HomeController@postChangePassword'));
        Route::get('/account', array('as' => 'account', 'uses' => 'HomeController@account'));
        Route::post('/account', array('as' => 'account', 'uses' => 'HomeController@postAccount'));
        Route::get('users/delete/{id}', array('as' => 'users.delete', 'uses' => 'UsersController@delete'));
        Route::get('users/update_password/{id}', array('as' => 'users.update_password', 'role' => 'admin.users.update', 'uses' => 'UsersController@changePassword'));
        Route::post('users/post_update_password/{id}', array('as' => 'users.update_password_put', 'role' => 'admin.users.update', 'uses' => 'UsersController@postChangePassword'));
        Route::resource('users', 'UsersController');
        Route::resource('roles', 'RolesController');
        Route::resource('news', 'NewsController');
        Route::get('news-categories/update-position/{id}/{value}', ['role' => 'backend', 'as' => 'news-categories.update-position', 'uses' => 'NewsCategoriesController@updatePosition']);
        Route::post('news-categories/getChildrenById', ['as' => 'news-categories.get-children-by-id', 'role' => 'backend', 'uses' => 'NewsCategoriesController@getChildrenById']);
        Route::resource('news-categories', 'NewsCategoriesController');
        Route::post('news/ajaxUpdateBulk', array('as' => 'news.updateBulk', 'role' => 'admin.news.update', 'uses' => 'NewsController@updateBulk'));
        Route::resource('news', 'NewsController');
        Route::put('news/{id}/comments/{commentId}/approve', array('as' => 'comments.approve', 'role' => 'backend', 'uses' => 'NewsController@approveComment'))->where(['id' => '[0-9]+', 'commentId' => '[0-9]+']);
        Route::put('news/{id}/comments/{commentId}/disapprove', array('as' => 'comments.disapprove', 'role' => 'backend', 'uses' => 'NewsController@disapproveComment'))->where(['id' => '[0-9]+', 'commentId' => '[0-9]+']);
        Route::delete('news/{id}/comments/{commentId}/delete', array('as' => 'comments.delete', 'role' => 'backend', 'uses' => 'NewsController@deleteComment'))->where(['id' => '[0-9]+', 'commentId' => '[0-9]+']);
        Route::get('static-pages/delete/{id}', array('as' => 'static-pages.delete', 'uses' => 'StaticPagesController@delete'));
        Route::resource('static-pages', 'StaticPagesController');
        Route::get('sliders/update-position/{id}/{value}', ['role' => 'backend', 'as' => 'sliders.update-position', 'uses' => 'SlidersController@updatePosition']);
        Route::resource('sliders', 'SlidersController');
        Route::get('experiences/update-position/{id}/{value}', ['role' => 'backend', 'as' => 'experiences.update-position', 'uses' => 'ExperiencesController@updatePosition']);
        Route::resource('experiences', 'ExperiencesController');
        Route::post('feedbacks/update-bulk', ['as' => 'feedbacks.update-bulk', 'role' => 'admin.feedbacks.update', 'uses' => 'FeedbacksController@updateBulk']);
        Route::resource('feedbacks', 'FeedbacksController', ['only' => [
            'index', 'update', 'edit', 'destroy', 'show'
        ]]);
        Route::get('elfinder', '\Barryvdh\Elfinder\ElfinderController@showIndex');
        Route::any('elfinder/connector', '\Barryvdh\Elfinder\ElfinderController@showConnector');
        Route::get('elfinder/ckeditor4', '\Barryvdh\Elfinder\ElfinderController@showCKeditor4');
        Route::get('elfinder/tinymce', '\Barryvdh\Elfinder\ElfinderController@showTinyMCE4');
        Route::get('caches/flushall', ['as' => 'caches.flushall', 'role' => 'backend', 'uses' => function() {
            \Cache::flush();
            return back();
        }]);
    });
});

Route::get('glide/{path}', function($path){
   $server = \League\Glide\ServerFactory::create([
       'source' => app('filesystem')->disk('public')->getDriver(),
   'cache' => storage_path('glide'),
   ]);
   return $server->getImageResponse($path, Input::query());
})->where('path', '.+');

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('tim-kiem', [ 'as' => 'home.search', 'uses' => 'HomeController@search']);
Route::get('{slug}', [ 'as' => 'home.static-page', 'uses' => 'HomeController@staticPage' ])->where(['slug' => '[a-zA-Z0-9\-]+']);
Route::get('danh-muc-tin/{slug}-{id}.html', [ 'as' => 'home.news-category', 'uses' => 'HomeController@getNewsCategory' ])->where([ 'slug' => '[a-zA-Z0-9\-]+', 'id' => '[0-9]+' ]);
Route::get('tin-tuc/{slug}-{id}.html', [ 'as' => 'home.news-detail', 'uses' => 'HomeController@getDetailNews' ])->where(['slug' => '[a-zA-Z0-9\-]+', 'id' => '[0-9]+']);
Route::get('lien-he.html', [ 'as' => 'home.contact', 'uses' => 'HomeController@getContact']);
Route::post('contact', ['as' => 'home.postContact', 'uses' => 'HomeController@contact']);
Route::get('404.html', array('as' => 'home.404', 'uses' => 'HomeController@get404'));
Route::post('consultant', ['as' => 'consultant', 'uses' => 'HomeController@consultant']);
Route::get('thong-bao.html', ['as' => 'notify', 'uses' => 'HomeController@notify']);
Route::post('comment', ['as' => 'comment', 'uses' => 'HomeController@comment']);