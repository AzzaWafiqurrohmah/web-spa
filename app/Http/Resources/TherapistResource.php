<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapistResource extends JsonResource
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
            'franchise_id' => $this->franchise_id,
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'address' => $this->address,
            'body_height' => $this->body_height,
            'body_weight' => $this->body_weight,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'start_working' => $this->start_working
        ];
    }
}
