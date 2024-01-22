<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'pretext' => Str::limit($this->content,50),
            'content' => $this->content,
            'status' => $this->status,
            'user' => $this->author_id,
            'feature_image' => $this->feature_image,
            'created' => $this->created_at,
            'updated' => $this->updated_at
        ];
    }
}
