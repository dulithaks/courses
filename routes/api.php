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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'namespace' => '\App\Http\Controllers\API',
], function () {
    // Users
    Route::get('users', 'UsersController@index');
    Route::post('users', 'UsersController@store');
    Route::delete('users/{user}', 'UsersController@delete');

    // Courses
    Route::get('courses', 'CoursesController@index');
    Route::post('courses', 'CoursesController@store');

    // Results
    Route::get('course/result', 'ResultsController@index');
    Route::post('course/assign', 'ResultsController@store');
    Route::put('course/result/{result}', 'ResultsController@update');
});