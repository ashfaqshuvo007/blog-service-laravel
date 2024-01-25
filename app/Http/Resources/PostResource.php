<?php

namespace App\Http\Resources;

use App\Models\User;
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
            'readingMinutes' => Str::readingMinutes($this->content, 200),
            'author' => UserResource::make(User::findOrFail($this->author_id)),
            'feature_image' => $this->feature_image,
            'created' => $this->created_at,
            'updated' => $this->updated_at
        ];
    }
}
