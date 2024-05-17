<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        return [
            'id' => format_id('customer', $user->franchise->raw_id, $this->gender, $this->id),
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'member_id' => format_member(format_id('customer', $user->franchise->raw_id, $this->gender, $this->id)),
            'start_member' => $this->start_member,
            'address' => $this->address,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'home_pict' => $this->home_pict,
            'home_details' => $this->home_details,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'latOffice' => Auth::user()->franchise->latitude,
            'lngOffice' => Auth::user()->franchise->longitude
        ];
    }
}
