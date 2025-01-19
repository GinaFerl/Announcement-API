<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'indexApi']);        // GET /api/posts
    Route::post('/', [PostController::class, 'storeApi']);       // POST /api/posts
    Route::get('/{id}', [PostController::class, 'showApi']);     // GET /api/posts/{id}
    Route::put('/{id}', [PostController::class, 'updateApi']);   // PUT /api/posts/{id}
    Route::delete('/{id}', [PostController::class, 'destroyApi']); // DELETE /api/posts/{id}
});