<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'products', 'middleware' => 'access'], function(){
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::patch('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
});


