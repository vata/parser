<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class CategoryListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows category list to parse.';

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
        $headers = ['Id', 'Category url'];

        $data = Category::all(['id', 'url'])->toArray();

        $this->table($headers, $data);
    }
}
