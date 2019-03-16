<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class ProductListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows parsed products list.';

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
        $headers = ['Id', 'Name', 'Sku', 'Price', 'Category Id'];

        $data = Product::all(['id', 'name', 'name', 'sku', 'price', 'category_id'])->toArray();

        $this->table($headers, $data);
    }
}
