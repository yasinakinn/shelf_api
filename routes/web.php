<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShelfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::post('user/login', [AuthController::class, 'login']); 
Route::post('user/register', [AuthController::class, 'register']);
Route::post('user/delete', [AuthController::class, 'delete']);
Route::post('user/updatePassword', [AuthController::class, 'updatePassword']);
Route::post('user/updateName', [AuthController::class, 'updateName']);
Route::post('user/updateClearance', [AuthController::class, 'updateClearance']);

// Path: shelf
Route::post('shelves', [ShelfController::class, 'index']);
Route::post('shelf/add', [ShelfController::class, 'store']);
Route::post('shelf/update', [ShelfController::class, 'update']); 