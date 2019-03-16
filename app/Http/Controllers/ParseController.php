<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\Models\Category;
use App\Models\Queue;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ConsoleCommand;
use Symfony\Component\Console\Output\ConsoleOutput;
use Artisan;

class ParseController extends Controller
{
    public function init()
    {
        $this->buildQueueMap();
        $this->parseProducts();
    }

    public function buildQueueMap()
    {
        $this->output = new ConsoleOutput;
        $cmd = new ConsoleCommand;
        $categoryControl = new CategoryController;
        $queueControl = new QueueController;
        $category_list = $categoryControl->index();

        if($category_list->count()) {
            $queueControl->clear();
            $this->output->writeln("Clear queue from previous run.");
            foreach ($category_list as $category) {
                $links = $this->getLinksFromCategory($category->url);
                $this->output->writeln("Found ".count($links)." links for category ".$category->url.".");
                $this->addLink2Queue($links,$category->id);
            }
        } else {
            $cmd->error("Category list is empty.");
            if ($cmd->outputStyle->confirm('Do you want to add new category?')) {
                $category_url = $cmd->outputStyle->ask('Enter category url.');
                Artisan::call('category:add', ['url' => $category_url]);
                $this->init();
            }
        }
    }

    public function parseProducts()
    {
        $queueControl = new QueueController;
        $productControl = new ProductController;
        $cmd = new ConsoleCommand;
        $queue_list = $queueControl->index();
        $cmd->info("Parsing products...");
        $cmd->outputStyle->progressStart($queue_list->count());
        foreach ($queue_list as $key => $item) {
            $product_data = $this->getContent($item->url);
            $product_data['category_id'] = $item->category_id;
            $productControl->store($product_data);
            $cmd->outputStyle->progressAdvance();
            // remove link from queue
            $queueControl->destroy($item->id);
        }
        $cmd->outputStyle->progressFinish();
        $cmd->info("Parsing complete.");
    }

    public function updateProducts()
    {
        $productControl = new ProductController;
        $cmd = new ConsoleCommand;
        
        $product_list = $productControl->index();
        if($product_list->count()) {
            $cmd->info("Updating products...");
            $cmd->outputStyle->progressStart($product_list->count());
            foreach ($product_list as $product) {
                $product_data = $this->getContent($product->url);
                $productControl->store($product_data);
                $cmd->outputStyle->progressAdvance();
            }

            $cmd->outputStyle->progressFinish();
            $cmd->info("Updating done.");
        } else {
            $cmd->error("Nothing to update. List is empty.");
            if ($cmd->outputStyle->confirm('Do you want to start new parsing?')) {
                $this->init();
            }
        }
    }

    public function getContent($link)
    {
        sleep(mt_rand(1, 3));

        $client = new Client();
        $crawler = $client->request('GET', $link);

        $config_name = config('app.productTitle');
        $config_descr = config('app.productDescr');
        $config_price = config('app.productPrice');
        $config_sku = config('app.productSKU');
        $config_image = config('app.productImage');

        $product = array();
        $product['name'] = $crawler->filter($config_name)->text();
        $product['description'] = trim($crawler->filter($config_descr)->text());
        $product['price'] = trim($crawler->filter($config_price)->text());
        $product['sku'] = ($crawler->filter($config_sku)->count()) ? $crawler->filter($config_sku)->text() : '';
        $product['image'] = $crawler->filter($config_image)->image()->getUri();
        $product['url'] = $link;
        
        return $product;
    }

    public function getLinksFromCategory($category_link)
    {
        sleep(mt_rand(1, 3));

        $client = new Client();
        $crawler = $client->request('GET', $category_link);
        $productLink = config('app.productLink');
        $crawler->filter($productLink)->each(function ($node) use (&$cat_links) {
            $cat_links[] = $node->attr('href');
        });

        $nextPage = $crawler->filter(config('app.nextPageLink'))->each(function ($node) {
            return $node->attr('href');
        });

        if($nextPage) {
            $cat_links = array_merge($cat_links, $this->getLinksFromCategory($nextPage[0]));
        }

        return $cat_links;
    }

    public function addLink2Queue($links,$category_id)
    {
        $cmd = new ConsoleCommand;
        $queueControl = new QueueController;

        foreach ($links as $link) {
            if(strlen($link) < 190) {
                $queueControl->store($link,$category_id);
            } else {
                $cmd->error("Url too long, skiped.");
            }
            
        }
    }
}
