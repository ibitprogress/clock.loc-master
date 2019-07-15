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


Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
],
    function()
{
    //Головна сторінка сайту
    Route::get('/', 'ClockController@mainPage')->name('main');
    Route::get('/shop', 'ClockController@shopPage')->name('shop');
    Route::get('/shop/{id}', 'ClockController@show');
    Route::get('checkout', ['uses' => 'OrderController@create', 'as' => 'checkout']);
    Route::get('checkout/success', ['uses' => 'OrderController@success', 'as' => 'checkoutSuccess']);
    Route::view('payment-and-delivery', 'paymentAndDelivery')->name('paymentAndDelivery');
    Route::view('contacts', 'contacts')->name('contacts');

    // Localization in Vue
    Route::get('/js/lang.js', 'LocalizationController@getLocalizationFile')->name('assets.lang');
});


Route::get('filter', 'ClockController@filter')->name('filter');
Route::post('orders', 'OrderController@store')->name('newOrder');
Route::post('feedbacks', 'FeedbackController@store')->name('new-feedback');
Route::post('cart/add', ['uses' => 'ClockController@addToCart', 'as' => 'addToCart']);
Route::post('cart/update', ['uses' => 'ClockController@updateCart', 'as' => 'updateCart']);
Route::post('cart/remove', ['uses' => 'ClockController@removeFromCart', 'as' => 'removeFromCart']);
Route::post('cart/get', 'ClockController@getCart');
Route::get('nova-poshta/get-warehouses', 'OrderController@getWarehouses');
Route::post('nova-poshta/get-warehouses', 'OrderController@getWarehouses');



Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::group(['namespace' => 'Auth'], function () {
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', function(){abort(404);})->name('register');
    Route::post('register', function(){abort(404);});

    // Password Reset Routes...
    Route::get('password/reset', function(){abort(404);})->name('password.request');
    Route::post('password/email', function(){abort(404);})->name('password.email');
    Route::get('password/reset/{token}', function(){abort(404);})->name('password.reset');
    Route::post('password/reset', function(){abort(404);});
});


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){

    Route::get('/', 'AdminController@index');

    Route::put('clocks/{id}/update', 'ClockController@updateFromTable');
    Route::delete('clocks/{id}/destroy', 'ClockController@destroyFromTable');
    Route::post('clocks/images/set-logo/{id}', 'ClockController@setLogo');
    Route::post('clocks/images/{id}', 'ClockController@loadImages');
    Route::delete('clocks/images/{id}', 'ClockController@deleteImage');
    Route::put('clocks/descriptions/{id}', 'ClockController@setDescriptions');
    Route::post('clocks/descriptions/{id}', 'ClockController@getDescriptions');
    Route::put('clocks/characteristics/{id}', 'ClockController@setCharacteristics');
    Route::post('clocks/characteristics/{id}', 'ClockController@getCharacteristics');
    Route::resource('clocks', 'ClockController');

    Route::get('orders/old', ['uses' => 'OrderController@oldOrders', 'as' => 'oldOrders']);
    Route::resource('orders', 'OrderController');

    Route::get('feedbacks/old', 'FeedbackController@oldFeedbacks');
    Route::resource('feedbacks', 'FeedbackController');

    //Блог
    Route::resource('articles', 'ArticleAdminController');
    Route::resource('articles-detail', 'ArticleDetailController');
    Route::post ('article-image', 'ArticleImageController@loadImage')->name('articles.image');

    // Обслуговування
    Route::get('clear', function(){
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:cache');
    });
    Route::get('migrate', function(){
        Artisan::call('migrate');
    });
    Route::get('queues', function(){
        Artisan::call('queue:work');
    });


});

Route::get('/home', 'HomeController@index')->name('home');



