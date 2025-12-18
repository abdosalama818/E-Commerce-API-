<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->getTranslation('title', $request->header('Accept-Language', 'en')),
            'description' => $this->getTranslation('description', $request->header('Accept-Language', 'en')),
            'price' => $this->price,
            'quantity' => $this->quantity,
            'image' => $this->image_url,
            'slug' => $this->slug,
        ];
    }
}
