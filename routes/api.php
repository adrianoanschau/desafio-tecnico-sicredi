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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('associates', 'AssociateController')->only([
    'index', 'show', 'store', 'update', 'destroy'
]);

Route::resource('schedules', 'ScheduleController')->only([
    'index', 'show', 'store', 'update', 'destroy'
]);
Route::put('schedules/{id}/openSession', 'ScheduleController@openSession')
    ->name('schedules.openSession');
Route::put('schedules/{id}/closeSession', 'ScheduleController@closeSession')
    ->name('schedules.closeSession');
Route::put('schedules/{id}/vote', 'ScheduleController@vote')
    ->name('schedules.vote');
