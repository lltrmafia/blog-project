<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;


Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->prefix('admin')->middleware('auth');
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::delete('categories/{category}/force-delete', [CategoryController::class, 'ForceDelete'])->name('categories.force-delete');
    Route::post('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::resource('categories', CategoryController::class);
    Route::get('posts/trash', [PostController::class, 'trash'])->name('posts.trash');
    Route::delete('posts/{post}/force-delete', [PostController::class, 'ForceDelete'])->name('posts.force-delete');
    Route::post('posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::resource('posts', PostController::class);
});

