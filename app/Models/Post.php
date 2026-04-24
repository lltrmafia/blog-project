<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'category_id',
        'user_id',
        'published_at',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $slug = Str::slug($post->title);
            $original = $slug;
            $count = 1;

            while (Post::where('slug', $slug)->exists()) {
                $slug = $original . '-' . $count++;
            }

            $post->slug = $slug;

        });
        static::forceDeleted(function ($post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        });
    }

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);

    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getCategoryNameAttribute()
    {
        return $this->category?->title;
    }

    public function scopeFilter($query, $filters): void
    {
        $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where('title', 'like', "%{$search}%");
        });

        $query->when($filters['category_id'] ?? null, function ($q, $categoryId) {
            $q->where('category_id', $categoryId);
        });
    }
}
