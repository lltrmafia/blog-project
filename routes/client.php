<?php

use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\PostController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

