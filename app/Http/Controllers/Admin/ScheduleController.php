<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Models\Reservation;
use App\Models\Therapist;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    use ApiResponser;

    private $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    private $days = [
        'Sunday' => 'Min',
        'Monday' => 'Sen',
        'Tuesday' => 'Sel',
        'Wednesday' => 'Rab',
        'Thursday' => 'Kam',
        'Friday' => 'Jum',
        'Saturday' => 'Sab',
    ];

    public function index()
    {
        $reservations = Reservation::where('date', date('Y-m-d'))
            ->where('time', '>=', date('H:i:s'))
            ->with(
                'reservationDetail',
                'therapist'
            )->get();

        return view('pages.admin.schedule.index', [
            'months' => $this->months,
            'days' => $this->days,
            'reservations' => $reservations
        ]);
    }

    public function json(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');

        $user = Auth::user();
        $schedules = Reservation::where('date', $date)
            ->with(
                'reservationDetail',
                'therapist'
            )->get();

        if ($user instanceof Therapist) {
            $schedules = Reservation::where('date', $date)
                ->where('therapist_id', $user->id)
                ->with(
                    'reservationDetail',
                    'therapist'
                )->get();
        }

        return $this->success(
            ScheduleResource::collection($schedules),
            'Berhasil mengambil seluruh data'
        );
    }
}
