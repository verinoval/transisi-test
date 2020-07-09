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

Route::post('login', 'AuthController@login');
Route::post('signup', 'AuthController@signup');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');

    Route::group(['prefix' => 'employee'], function () {
        Route::post('get', 'EmployeesController@index');
        Route::get('/{id}', 'EmployeesController@employee_detail');
        Route::post('create', 'EmployeesController@employee_add');
        Route::put('update/{id}', 'EmployeesController@employee_update');
        Route::delete('delete/{id}', 'EmployeesController@employee_delete');
    });
});