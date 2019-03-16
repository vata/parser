<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class CategoryAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:add {url : Category url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add category to parsing list';

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
        $url = $this->getUrl();
        $category = Category::where('url',$url)->first();

        if(!$category)
        {
            $category = new Category;
            $category->url = $url;
            $category->save();
            $this->info("Category url $url added to parsing list!");
        } else {
            $this->error("Category already exists!");
        }
    }

    private function getUrl()
    {
        $url = $this->argument('url');

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception("Invalid URL '$url'");
        }

        return $url;
    }
}
