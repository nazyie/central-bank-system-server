<?php

use App\Http\Controllers\WebAuditTrailController;
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
    Route::resource('dashboard', WebDashboardController::class, ['names' => ['index' => 'View Dashboard']]);
    Route::resource('member', WebMemberController::class, ['names' => ['index' => 'List of Members', 'show' => 'View Member', 'create' => 'Create Member', 'edit' => 'Update Member']]);
    Route::resource('user', WebUserController::class, ['names' => ['index' => 'List of Users', 'show' => 'View User', 'create' => 'Create User', 'edit' => 'Update User']]);
    Route::resource('role', WebRoleController::class, ['names' => ['index' => 'List of Roles', 'show' => 'View Role', 'create' => 'Create Role', 'edit' => 'Update Role']]);
    Route::resource('audit-trail', WebAuditTrailController::class, ['names' => ['index' => 'List of Audit Trails', 'show' => 'View Audit Trail']]);
});
