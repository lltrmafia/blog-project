<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'image' => $this->image,
            'category_id' => $this->category_id,
            'category_name' => $this->category_name,
            'user_id' => $this->user_id,
            'published_at' => $this->published_at,
            'permissions' => [
                'update' => $request->user()?->can('update', $this->resource),
                'delete' => $request->user()?->can('delete', $this->resource),
                'restore' => $request->user()?->can('restore', $this->resource),
                'forceDelete' => $request->user()?->can('forceDelete', $this->resource),
            ],
        ];
    }
}
