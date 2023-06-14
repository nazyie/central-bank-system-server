<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\LoggerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebSecurityController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::resource('member', MemberController::class);
// Route::resource('role', RoleController::class);
// Route::resource('action', ActionController::class);
// Route::resource('user', UserController::class);
// Route::resource('audit-trail', AuditTrailController::class);
// Route::resource('logger', LoggerController::class);
// Route::post('sign-in', [WebSecurityController::class, 'signIn']);
// Route::post('verify/otp', [WebSecurityController::class, 'verify']);