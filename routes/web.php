<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashBoardController;
use App\Http\Controllers\Web\GeneratorController;
use App\Http\Controllers\Web\ToolController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashBoardController::class, 'dashboard'])->name('dashboard');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('resetpassword');
    Route::post('/reset-password/store', [AuthController::class, 'resetPasswordStore'])->name('resetpassword.store');
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('profile-update', [AuthController::class, 'profileUpdate'])->name('profile.update');

    Route::resource('tool', ToolController::class);
    Route::resource('generator', GeneratorController::class);

    //get data
    Route::post('tool/getData', [ToolController::class, 'getToolData'])->name('admin.tool.getData');
    Route::post('generator/getData', [GeneratorController::class, 'getGeneratorData'])->name('admin.generator.getData');

    //status change
    Route::get('tool/status/{id}/{status}', [ToolController::class, 'status'])->name('tool.status');
    Route::get('generator/status/{id}/{status}', [GeneratorController::class, 'status'])->name('generator.status');
});
