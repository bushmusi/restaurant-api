<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\SiUnitController;

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
