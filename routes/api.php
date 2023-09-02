<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/products', function (Request $request) {
//     return $request->user();
// });

Route::prefix('products')->group(function () {
    Route::post('/', [ProductController::class, 'create']);

    Route::get('/', [ProductController::class, 'list']);

    Route::get('/{id}', [ProductController::class, 'get']);

    Route::put('/{id}', [ProductController::class, 'update']);

    Route::put('/{id}/photo', [ProductController::class, 'uploadPhoto']);

    Route::delete('/{id}', [ProductController::class, 'delete']);
});
