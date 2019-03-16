<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class ProductClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear product list';

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
        if ($this->confirm('Are you sure you want to do this? This will delete all products from the list! [yes|no]'))
        {
            Product::truncate();
            $this->info("Product list cleared!");
        }
    }
}
