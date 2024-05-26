<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer_id' => $this->customer_id,
            'therapist_id' => $this->therapist_id,
            'date' => $this->date,
            'payment_type' => $this->payment_type,
            'transport_cost' => $this->transport_const,
            'discount' => $this->discount,
            'totals' => $this->totals
        ];
    }
}
