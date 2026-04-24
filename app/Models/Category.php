<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'parent_id',
    ];
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $slug = Str::slug($category->title);
            $original = $slug;
            $count = 1;

            while (Category::where('slug', $slug)->exists()) {
                $slug = $original . '-' . $count++;
            }

            $category->slug = $slug;
        });
    }
}
