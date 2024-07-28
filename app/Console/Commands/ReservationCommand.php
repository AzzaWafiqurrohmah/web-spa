<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reservation-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        $reservationsId = Reservation::query()
            ->where('date', $now->format('Y-m-d'))
            ->where('time', '>=', $now->format('H:i'))
            ->where('status', '=', 'processed')
            ->pluck('id');
        foreach ($reservationsId as $id){
            $reservation = Reservation::find($id);
            $reservation->update(['status' => 'succes']);
        }
    }
}
