<?php

use App\Http\Controllers\Api\GeneratorController;
use App\Http\Controllers\Api\ToolController;
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

// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);
// Route::post('otp-generate', [AuthController::class, 'otpGenerate']);
// Route::post('otp-verify', [AuthController::class, 'otpVerify']);
// Route::post('forget-password', [AuthController::class, 'forgetPassword']);

// Route::middleware(['auth:api'])->Group(function () {
// Route::post('logout', [AuthController::class, 'logout']);
// Route::post('profile-update', [AuthController::class, 'profileUpdate']);

// Route::apiResource('tool', ToolController::class);
Route::get('tool', [ToolController::class, 'index']);
Route::get('tool/{id}', [ToolController::class, 'show']);
Route::get('generator/{tool?}', [GeneratorController::class, 'index']);
Route::get('generator/show/{id}', [GeneratorController::class, 'show']);
// Route::apiResource('generator', GeneratorController::class);
// });
