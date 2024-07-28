<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MemberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:member-command';

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
        $customersId = Customer::query()
            ->where('is_member', '=', '1')
            ->whereRaw('DATE_ADD(start_member, INTERVAL 1 YEAR) < ?', [$now])
            ->pluck('id');

        foreach ($customersId as $id){
            $customer = Customer::find($id);
            $customer->update([
                'is_member' => 0,
                'start_member' => null
            ]);
        }
    }
}
