<?php

namespace App\Console;

use App\Console\Commands\SaveCategoriesRating;
use App\Console\Commands\SaveUsersRating;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(SaveUsersRating::class)->monthly();
        $schedule->command(SaveCategoriesRating::class)->monthly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
