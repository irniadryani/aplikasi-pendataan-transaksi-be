<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesDetailController;
use App\Http\Controllers\TransaksiController;

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

Route::get('/barang', [BarangController::class, 'indexBarang']);
Route::post('/barang', [BarangController::class, 'storeBarang']);
Route::get('/barang/{barang}', [BarangController::class, 'showBarang']);
Route::put('/barang/{barang}', [BarangController::class, 'updateBarang']);
Route::delete('/barang/{barang}', [BarangController::class, 'destroyBarang']);

Route::get('/customer', [CustomerController::class, 'indexCustomer']);
Route::post('/customer', [CustomerController::class, 'storeCustomer']);
Route::get('/customer/{customer}', [CustomerController::class, 'showCustomer']);
Route::put('/customer/{customer}', [CustomerController::class, 'updateCustomer']);
Route::delete('/customer/{customer}', [CustomerController::class, 'destroyCustomer']);

Route::get('/sales', [SalesController::class, 'indexSales']);
Route::post('/sales', [SalesController::class, 'storeSales']);
Route::get('/sales/{sales}', [SalesController::class, 'showSales']);
Route::put('/sales/{sales}', [SalesController::class, 'updateSales']);
Route::delete('/sales/{sales}', [SalesController::class, 'destroySales']);

Route::get('/detail', [SalesDetailController::class, 'indexSalesDetail']);
Route::post('/detail', [SalesDetailController::class, 'storeSalesDetail']);
Route::get('/detail/{detail}', [SalesDetailController::class, 'showSalesDetail']);
Route::put('/detail/{detail}', [SalesDetailController::class, 'updateSalesDetail']);
Route::delete('/detail/{detail}', [SalesDetailController::class, 'destroySalesDetail']);

// Route::post('/transaksi', [TransaksiController::class, 'transaksi']);
Route::post('/transaksi', [TransaksiController::class, 'createTransaksi']);
Route::delete('/transaksi/{id}', [TransaksiController::class, 'deleteTransaksi']);

