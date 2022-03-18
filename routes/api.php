<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\SiUnitController;
use App\Http\Controllers\Api\Stock\StockItemController;
use App\Http\Controllers\Api\Stock\StockInController;
use App\Http\Controllers\Api\Stock\StockOutController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\StockWastageController;

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

Route::controller(StockInController::class)->prefix('stock/')->group(function() {
    Route::prefix('in/')->group(function () {
        Route::post('create','create');
        Route::put('update','update');
        Route::get('get-all','getStockInAll');
        Route::get('get/{id}','getStockInItem');
        Route::get('get-stock-id/{stock_id}','getStockInByStckID');
        Route::delete('delete/{id}','deleteStockIn');
    });
});

Route::controller(EmployeeController::class)->prefix('employee/')->group(function() {
    Route::post('create','create');
    Route::put('update','update');
    Route::get('get-all','getAll');
    Route::get('get/{id}','getByID');
    Route::delete('delete/{id}','delete');
});

Route::controller(StockOutController::class)->prefix('stock/')->group(function() {
    Route::prefix('out/')->group(function () {
        Route::post('create','create');
        Route::put('update','update');
        Route::get('get-all','getStockOutAll');
        Route::get('get/{id}','getStockOutItem');
        Route::get('get-stock-id/{stock_id}','getStockOutByStckID');
        Route::delete('delete/{id}','deleteStockOut');
    });
});

Route::controller(StockWastageController::class)->prefix('stock/')->group(function() {
    Route::prefix('wastage/')->group(function () {
        Route::post('create','create');
        Route::put('update','update');
        Route::get('get-all','getStockWastageAll');
        Route::get('get/{id}','getStockWastageItem');
        Route::get('get-stock-id/{stock_id}','getStockWastageByStckID');
        Route::delete('delete/{id}','deleteStockWastage');
    });
});
