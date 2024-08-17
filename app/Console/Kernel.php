<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\SchedulingPreference;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\ProcessAutomaticPayments::class,
        // Add other commands here
    ];

    protected function schedule(Schedule $schedule)
    {
        $preference = SchedulingPreference::first();
        
        if ($preference) {
            switch ($preference->frequency) {
                case 'daily':
                    $schedule->command('payments:process')->daily();
                    break;
                case 'weekly':
                    $schedule->command('payments:process')->weekly();
                    break;
                case 'monthly':
                    $schedule->command('payments:process')->monthly();
                    break;
                default:
                    $this->error('Invalid frequency set.');
                    break;
            }
        } else {
            $this->error('Scheduling preference not found.');
        }
    }
}
