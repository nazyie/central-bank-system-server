<?php

use App\Http\Controllers\WebDashboardController;
use App\Http\Controllers\WebLoginController;
use App\Http\Controllers\WebMemberController;
use App\Http\Controllers\WebRoleController;
use App\Http\Controllers\WebUserController;
use Illuminate\Support\Facades\Route;

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

Route::resource('sign-in', WebLoginController::class);
Route::post('sign-out', [WebLoginController::class, 'destroy']);

Route::group(['middleware' => ['auth']], function () {
    Route::resource('dashboard', WebDashboardController::class);
    Route::resource('member', WebMemberController::class);
    Route::resource('user', WebUserController::class);
    Route::resource('role', WebRoleController::class);
});
