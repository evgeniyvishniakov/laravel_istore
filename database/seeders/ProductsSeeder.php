<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Iphone 12',
            'article'  => 'I37234',
            'description'  => 'Iphone',
            'price'  => '23000',
            'stock_quantity'  => '10',
        ]);
    }
}
