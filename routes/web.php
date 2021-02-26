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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads','ThreadsController@index');
Route::get('/threads/create','ThreadsController@create');
Route::post('/threads', 'ThreadsController@store')->middleware('must-be-confirmed');

Route::get('threads/{channel}','ThreadsController@index');
Route::get('/threads/{channel}/{thread}','ThreadsController@show');
Route::delete('/threads/{channel}/{thread}','ThreadsController@destroy');

Route::get('/threads/{channel}/{thread}/replies','RepliesController@index');

Route::post('/threads/{channel}/{thread}/replies','RepliesController@store');

#-----------  Delete Replies  -----------------
Route::delete('/replies/{reply}','RepliesController@destroy');

#-----------  Thread Suscriptions
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')
    ->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')
    ->middleware('auth');


#-----------  Update Replies  -----------------
Route::patch('/replies/{reply}','RepliesController@update');

#=========== FAVORITES  ====================
#----- this reply is my favorite
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
#----- this reply is not my favorite anymore
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

#--------------  User Profile  ---------------
Route::get('/profiles/{user}','ProfilesController@show')->name('profile');

#-------------  Notifications  --------------
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');

Route::get('/register/confirm', 'Api\RegisterConfirmationController@index')->name('register.confirm');

#============================================
#  Searching
#-------------------------------------------

Route::get('api/users', 'Api\UsersController@index');

#-----------  User Avatar  -------------------------
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')
    ->middleware('auth')->name('avatar');