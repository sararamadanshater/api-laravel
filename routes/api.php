<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Auth;
// use App\Http\Controllers\Controller;
// use App\Http\Controllers\Controller\Api\Admin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>['api','checkpassword','checklanguage'],'namespace'=>'Api'],function(){

   Route::post('getcategories','CategoryController@index');
   Route::post('getcategoryById','CategoryController@getCategoryById');
   Route::post('changedisplay','CategoryController@changeDisplay');


   Route::group(['prefix'=>'admin','namespace=>Admin'],function(){
     Route::post('login','Admin\AuthController@login');
     Route::post('logout','Admin\AuthController@logout')->middleware('assignGuard:admin-api');

   });

   Route::group(['prefix'=>'user','namespace=>User'],function(){

    Route::post('login','User\AuthController@login');
    Route::post('logout','User\AuthController@logout')->middleware('assignGuard:user-api');
  });
  


});



Route::group(['prefix'=>'user','middleware'=>'assignGuard:user-api'],function(){

    Route::post('profile',function(){
      // return "only authenticated user can reach me";
      return Auth::user();
    });
});