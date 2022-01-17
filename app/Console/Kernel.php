<?php

namespace App\Console;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreContractRequest;
use Carbon\Carbon;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            //Bring all the contracts
            $contracts = Contract::all();
            $today = Carbon::now();

            //Check them if today is endDate and change to inactive
            foreach ($contracts as $contract) {
                $endDate = new Carbon($contract->endDate);
                if($today->greaterThanOrEqualTo($endDate) && $contract->status == 'active'){
                    $contract->status ='inactive';
                    $contract->save();
                    info('changed to inactive');
                }
            }

            //Check them is today is startDate and change it to active
            foreach ($contracts as $contract) {
                $startDate = new Carbon($contract->startDate);
                if($today->greaterThanOrEqualTo($startDate) && $contract->status == 'pending'){
                    $contract->status ='active';
                    $contract->save();
                    info('changed to active');

                }
            }

            

        })->dailyAt('10:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
