<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'          => $this->uuid,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'excerpt'       => $this->excerpt,
            'content'       => $this->content,
            'featured_image'    => $this->featured_image
                ? url('storage/' . $this->featured_image)
                : url('images/default.png'),
            'scheduled_at'  => $this->scheduled_at,
            'views'         => $this->views,
            'link'          => $this->link,
            'video'         => $this->video,
            'author'        => $this->user?->name,
            'category'      => $this->category?->name,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
