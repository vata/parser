<?php

namespace App\Console;

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
        Commands\MigrateCommand::class,
        Commands\ParseCommand::class,
        Commands\ReportCommand::class,
        Commands\CategoryListCommand::class,
        Commands\CategoryAddCommand::class,
        Commands\CategoryDeleteCommand::class,
        Commands\CategoryClearCommand::class,
        Commands\ProductListCommand::class,
        Commands\ProductUpdateCommand::class,
        Commands\ProductDeleteCommand::class,
        Commands\ProductClearCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
