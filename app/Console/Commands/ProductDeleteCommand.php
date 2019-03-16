<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class ProductDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete product from the list. Use product:list command to get product id.';

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
        $id = $this->argument('id');

        try {
            $item = Product::findOrFail($id);
            $item->delete();
            $this->info("Product removed from the list!");
        } catch (\Exception $e) {
            $this->error("Product not found!");
        }
    }
}
