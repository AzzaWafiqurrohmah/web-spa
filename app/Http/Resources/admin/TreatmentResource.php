<?php

namespace App\Http\Resources\admin;

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
            'duration' => $this->duration,
            'pictures' => $this->pictures,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'price' => $this->price,
            'member_price' => $this->member_price,
            'discount' => $this->discount,
            'tools' => $this->tools->pluck('name')->implode(', '),
            'materials' => $this->materials->pluck('name')->implode(', ')

        ];
    }
}
