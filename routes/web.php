<?php

use App\Http\Controllers\WebDashboardController;
use App\Http\Controllers\WebLoginController;
use App\Http\Controllers\WebMemberController;
use Illuminate\Support\Facades\Log;
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
Route::resource('dashboard', WebDashboardController::class);
Route::resource('member', WebMemberController::class);


/**
 * This would be an error response for processor use
 */
// Route::get('/bad-request', function () {
//     $response = [
//         'msg' => 'Internal Server Error'
//     ];
//     return response($response, 400);
// })->name('bad-request');
