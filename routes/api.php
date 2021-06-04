<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentApiController;
use App\Http\Controllers\TodoApiController;
use App\Http\Controllers\DepartmentApiController;
use App\Http\Controllers\EmployeeApiController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::middleware('auth:sanctum')->get('/studentapi/{name}','App\Http\Controllers\EmployeeController@studentapi')->name('student.api');


// Route::middleware('auth:sanctum')->get('/studentapi','App\Http\Controllers\EmployeeController@studentapic')->name('student.postapi');

// Route::middleware('auth:sanctum')->post('/studentapi','App\Http\Controllers\EmployeeController@studentpostapi')->name('student.postapi');

Route::middleware('auth:sanctum')->resource('studentapi',StudentApiController::class);

Route::get('studentapi/search/{name}',[StudentApiController::class,'search']); 


/* JWt Api Routes */
Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('profile', 'AuthController@profile');
    Route::post('payload', 'AuthController@payload');

});

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',

], function ($router) {

    Route::resource('todos', 'TodoApiController');
    Route::get('search/{title}',[TodoApiController::class,'search']);
    Route::post('upload',[TodoApiController::class,'upload']);
    Route::patch('updatetitle',[TodoApiController::class,'updatetitle']);
    Route::get('qb',[TodoApiController::class,'qb']);
});

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',

], function ($router) {

    Route::resource('departments', 'DepartmentApiController');

});

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',

], function ($router) {

    Route::resource('employees', 'EmployeeApiController');

});

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',

], function ($router) {

    Route::resource('students', 'StudentApiController');
    Route::get('/students/search/{name}',[StudentApiController::class,'search']);
});