<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::name('category.')->prefix('/category')->group(function () {
    Route::get('get-cat-by-type', [CategoryController::class, 'getCatByType'])->name('getcatbytype');
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/datatables', [CategoryController::class, 'dataTables'])->name('datatables');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('/store/{id}', [CategoryController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
});

Route::name('transaction.')->prefix('/transaction')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::get('/datatables', [TransactionController::class, 'dataTables'])->name('datatables');
    Route::get('/create', [TransactionController::class, 'create'])->name('create');
    Route::post('/store', [TransactionController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [TransactionController::class, 'edit'])->name('edit');
    Route::post('/store/{id}', [TransactionController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [TransactionController::class, 'delete'])->name('delete');
});

