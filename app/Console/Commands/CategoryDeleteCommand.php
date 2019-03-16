<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class CategoryDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:delete {id : Category id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete category from parsing. Use category:list command to get category id.';

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
            $item = Category::findOrFail($id);
            $item->delete();
            $this->info("Category removed from parsing list!");
        } catch (\Exception $e) {
            $this->error("Category not found!");
        }
    }
}
