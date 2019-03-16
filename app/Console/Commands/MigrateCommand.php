<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db-migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all necessary tables to the project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('Do you really want to run this command? [yes|no]'))
        {
            Artisan::call('migrate', ["--force"=> true ]);
            Artisan::call('db:seed', ["--class"=> 'CategoryTableSeeder' ]);
            $this->info("Migration complete!");
        }
    }
}
