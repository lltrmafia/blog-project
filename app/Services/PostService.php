<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public static function store(array $data, $request): Post
    {
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }
        $data['user_id'] = Auth::id();
        return Post::create($data);
    }

    public static function update(Post $post, array $data, $request): Post
    {
        if ($request->hasFile('image')) {

            // удалить старую
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $data['image'] = $request->file('image')->store('posts', 'public');
        }
        $post->update($data);
        return $post->fresh();
    }
    public static function destroy(Post $post): void
    {
        $post->delete();
    }

    public static function restore($restoredPost): Post
    {

        $restoredPost->restore();
        return $restoredPost;
    }
    public static function forceDelete($post): void
    {
        $post->forceDelete();
    }
}
