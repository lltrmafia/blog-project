<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;

class CategoryService
{
    public static function store(array $data): Category
    {
        return Category::create($data);
    }
    public static function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category->fresh();
    }
    public static function destroy(Category $category): void
    {
        $category->delete();
    }

    public static function restore($restoredCategory): Category
    {

        $restoredCategory->restore();
        return $restoredCategory;
    }
    public static function forceDelete($id): void
    {
        $deletedCategory = Category::withTrashed()->findOrFail($id);
        if($deletedCategory->parent_id === null){
            Category::withTrashed()->where('parent_id', $id)->update(['parent_id' => null]);
        }
        Post::where('category_id', $id)->update(['category_id' => null]);
        $deletedCategory->forceDelete();
    }
}
