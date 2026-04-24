<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\PostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'category_id']);
        $posts = PostResource::collection(
            Post::with(['category', 'user'])->
            filter($filters)->latest()->paginate(3)->withQueryString());
        $categories = Category::all();
        return inertia('Client/Post/Index', compact('posts', 'filters', 'categories'));
    }
    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }
        $post = PostResource::make($post->load(['category', 'user']))->resolve();
        return inertia('Client/Post/Show', compact('post'));
    }
}
