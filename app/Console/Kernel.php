<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\SchedulerTask;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use App\Models\Task;
use App\Http\Controllers\SchedulerController;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

     protected function schedule(Schedule $schedule)
     {
         $schedule->call(function () {
             $tasks = Task::where('status', 'in queue')
                          ->where('execution_date', '<=', now())
                          ->get();
     
             foreach ($tasks as $task) {
                 app(SchedulerController::class)->executeTask($task->id);
             }
         })->everyMinute();
     }
     


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
