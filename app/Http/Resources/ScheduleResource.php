<?php

namespace App\Http\Resources;

use App\Service\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $date_start = $this->date;
        $date_start->setTimeFromTimeString($this->time);

        $minutes = ReservationService::getDurations($this->reservationDetail);
        $date_end = $date_start->copy()->addMinute($minutes);

        return [
            'therapist_id' => $this->therapist->id,
            'therapist_name' => $this->therapist->fullname,
            'therapist_img' => Storage::url($this->therapist->image),
            'date' => $this->date,
            'hour' => $date_start->format('H'),
            'time_start' => [
                'val' => $date_start->format('H:i'),
                'timestamp' => $date_start->timestamp,
            ],
            'time_end' => [
                'val' => $date_end->format('H:i'),
                'timestamp' => $date_end->timestamp,
            ],
        ];
    }
}
