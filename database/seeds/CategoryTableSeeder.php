<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            'id' => 1,
            'url' => 'https://prom.ua/Futbolki-muzhskie?a4846=30796',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
