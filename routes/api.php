<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShelfController;
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
// Path: user
Route::middleware('auth:sanctum')->post('user/login', [AuthController::class, 'login']); 
Route::middleware('auth:sanctum')->post('user/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('user/delete', [AuthController::class, 'delete']);
Route::middleware('auth:sanctum')->post('user/updatePassword', [AuthController::class, 'updatePassword']);
Route::middleware('auth:sanctum')->post('user/updateName', [AuthController::class, 'updateName']);
Route::middleware('auth:sanctum')->post('user/updateClearance', [AuthController::class, 'updateClearance']);

// Path: clearance
Route::middleware('auth:sanctum')->post('clearances', [ClearanceController::class, 'index']);
Route::middleware('auth:sanctum')->post('clearance/add', [ClearanceController::class, 'store']);
Route::middleware('auth:sanctum')->post('clearance/update', [ClearanceController::class, 'update']);
Route::middleware('auth:sanctum')->post('clearance/delete', [ClearanceController::class, 'delete']);

// Path: shelf
Route::middleware('auth:sanctum')->post('shelves', [ShelfController::class, 'index']);
Route::middleware('auth:sanctum')->post('shelf', [ShelfController::class, 'get']);
Route::middleware('auth:sanctum')->post('shelf/add', [ShelfController::class, 'store']);
Route::middleware('auth:sanctum')->post('shelf/update', [ShelfController::class, 'update']);
Route::middleware('auth:sanctum')->post('shelf/delete', [ShelfController::class, 'delete']);
Route::middleware('auth:sanctum')->post('shelf/search', [ShelfController::class, 'search']);