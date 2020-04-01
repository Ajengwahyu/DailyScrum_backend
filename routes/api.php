<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
 
Route::middleware(['jwt.verify'])->group(function(){
    Route::get('daily_scrum', "DailyController@index"); 
    Route::get('daily_scrum/{limit}/{offset}', "DailyController@getAll"); 
    Route::post('daily_scrum', 'DailyController@store'); 
    Route::delete('daily_scrum/{id}', "DailyController@delete"); 
});

