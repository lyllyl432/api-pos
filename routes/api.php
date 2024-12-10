<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('brands', BrandController::class);
    Route::post('orders/bulk', ['uses' => 'OrderController@bulkOrderStore']);
    Route::get('orderitems', ['uses' => 'OrderItemController@index']);
    Route::post('orderitems/bulk', ['uses' => 'OrderController@bulkOrderItemStore']);
    Route::post('cart', ['uses' => 'ProductController@cartProducts']);
});
