<?php

use App\Http\Controllers\api\InventoryListController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/InventoryList',[InventoryListController::class, 'showList']);
Route::get('/InventoryList/delete/{id}',[InventoryListController::class, 'deleteItem']);
Route::post('/InventoryList/Add',[InventoryListController::class, 'addItem']);
Route::put('/InventoryList/update',[InventoryListController::class, 'updateItem']);