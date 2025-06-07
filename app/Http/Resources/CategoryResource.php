<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'icon_url' => $this->icon_url,
            'parent' => $this->parent ? new CategoryResource($this->parent) : null,
            'status' => $this->status ? 'active' : 'inactive',
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
