<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $canCreate = auth()->user()->can('create', Post::class);
        $posts = PostResource::collection(Post::with(['category', 'user'])->get())->resolve();
        $trashedPosts = PostResource::collection(Post::onlyTrashed()->with(['category', 'user'])->get())->resolve();
        return inertia('Admin/Post/Index', compact('posts', 'trashedPosts', 'canCreate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        $categories = CategoryResource::collection(Category::all())->resolve();
        $canPublish = auth()->user()->can('publish', Post::class);
        return inertia('Admin/Post/Create', compact('categories', 'canPublish'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Post::class);
        $data = $request->validated();
        if ($request->input('action') === 'publish') {
            $this->authorize('publish', Post::class);
            $data['status'] = 'published';
        }else{
            $data['status'] = 'draft';
        }
        $post = PostService::store($data, $request);
        return PostResource::make($post)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        $post = PostResource::make($post->load(['category', 'user']))->resolve();
        return inertia('Admin/Post/Show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $post = PostResource::make($post->load(['category', 'user']))->resolve();
        $categories = CategoryResource::collection(Category::all())->resolve();
        return inertia('Admin/Post/Edit', compact('post',  'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validated();
        if ($request->input('action') === 'publish') {
            $this->authorize('publish', Post::class);
            $data['status'] = 'published';
        }else{
            $data['status'] = 'draft';
        }
        $post = PostService::update($post, $data, $request);
        return PostResource::make($post->load(['category', 'user']))->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json([
            'message' => 'success'
        ], Response::HTTP_OK);
    }
    public function trash()
    {
        $this->authorize('viewAny', Post::class);
        $posts = PostResource::collection(Post::with(['category', 'user'])->get())->resolve();
        $categories = CategoryResource::collection(Category::all())->resolve();
        $trashedPosts = PostResource::collection(Post::onlyTrashed()->with(['category', 'user'])->get())->resolve();
        return inertia('Admin/Post/Trash', compact('trashedPosts', 'categories', 'posts'));
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('restore', $post);
        PostService::restore($post);
        return $post;
    }
    public function ForceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $post);

        PostService::forceDelete($post);

        return response()->json([
            'message' => 'success'
        ], Response::HTTP_OK);
    }
}
