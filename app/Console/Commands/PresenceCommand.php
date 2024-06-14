<?php

namespace App\Console\Commands;

use App\Models\Presence;
use App\Models\Therapist;
use Illuminate\Console\Command;

class PresenceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:presence-command';

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
        $therapists = Therapist::all();
        foreach ($therapists as $therapist)
        {
            Presence::create([
                'therapist_id' => $therapist->id ,
                'status' => 'empty' ,
            ]);
        }
    }
}
