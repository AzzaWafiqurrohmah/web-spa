<?php

namespace App\Http\Resources\owner;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FranchiseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'raw_id' => $this->raw_id,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }
}
