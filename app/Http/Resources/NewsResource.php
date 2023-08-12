<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "slug" => $this->slug,
            "title" => $this->title,
            "content" => $this->content,
            "images" => $this->images,
            "category" => $this->category?->name,
            "author" => $this->user?->name,
            "created_at" => Carbon::parse($this->created_at)->format('d M Y'),
            "comments" => $this->whenLoaded('comments', function () {
                return NewsCommentResource::collection($this->comments);
            }),
        ];
    }
}
