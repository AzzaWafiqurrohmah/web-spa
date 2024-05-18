<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
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
            'category_id' => $this->category_id,
            'franchise_id' => $this->franchise_id,
            'name' => $this->name,
            'duration' => $this->duration . " menit",
            'pictures' => $this->pictures,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'price' => "Rp " . $this->price,
            'discount' => $this->discount . " %"
        ];
    }
}
