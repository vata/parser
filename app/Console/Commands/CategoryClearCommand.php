<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class CategoryClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear category list';

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
        if ($this->confirm('Are you sure you want to do this? This will delete all categories from the list! [yes|no]'))
        {
            Category::truncate();
            $this->info("Category list cleared!");
        }
    }
}
