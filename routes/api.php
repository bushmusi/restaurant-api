<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\SiUnitController;
use App\Http\Controllers\Api\Stock\StockItemController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(DepartmentController::class)->prefix('dept/')->group(function(){
    Route::post('create','add');
    Route::put('update','update');
    Route::get('get-all','getAll');
    Route::get('get/{id}','getById');
    Route::delete('delete/{id}', 'delete');
});

Route::controller(SiUnitController::class)->prefix('si-unit/')->group(function() {
    Route::post('create','add');
    Route::put('update','update');
    Route::get('get-all','getAll');
    Route::get('get/{id}','getById');
    Route::delete('delete/{id}','deleteItem');
});

Route::controller(StockItemController::class)->prefix('stock/')->group(function() {

    Route::prefix('item/')->group(function () {
        Route::post('create','createStockItem');
        Route::put('update','updateStockItem');
        Route::get('get-all','getStockItemAll');
        Route::get('get/{id}','getStockItem');
        Route::get('filter-data','filterData');
        Route::delete('delete/{id}','deleteStockItem');
    });
});
