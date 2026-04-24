<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trashedCategories = CategoryResource::collection(Category::onlyTrashed()->get())->resolve();
        $categories = CategoryResource::collection(Category::all())->resolve();
        return inertia('Admin/Category/Index', compact('categories', 'trashedCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        return inertia('Admin/Category/Create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $category = CategoryService::store($data);
        return CategoryResource::make($category)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = CategoryResource::make($category)->resolve();
        return inertia('Admin/Category/Show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = CategoryResource::collection(Category::where('id', '!=', $category->id)->get())->resolve();
        $category = CategoryResource::make($category)->resolve();
        return inertia('Admin/Category/Edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $data = $request->validated();
        $category = CategoryService::update($category, $data);
        return CategoryResource::make($category)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        CategoryService::destroy($category);
        return response()->json([
            'message' => 'success'
        ], Response::HTTP_OK);
    }

    public function trash()
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        $trashedCategories = CategoryResource::collection(Category::onlyTrashed()->get())->resolve();
        return inertia('Admin/Category/Trash', compact('trashedCategories', 'categories'));
    }

    public function restore($id)
    {
        $restoredCategory = Category::withTrashed()->findOrFail($id);
        CategoryService::restore($restoredCategory);
        return $restoredCategory;
    }
    public function ForceDelete($id)
    {
        CategoryService::forceDelete($id);
        return response()->json([
            'message' => 'success'
        ], Response::HTTP_OK);
    }
}
