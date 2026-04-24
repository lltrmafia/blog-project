<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\PostResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $posts = PostResource::collection($category->posts()->with(['user'])->where('status', 'published')->latest()->get())->resolve();
        $categories = Category::all();
        return inertia('Client/Category/Show', compact('posts', 'categories'));
    }
}
