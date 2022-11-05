<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item')->insert([
            'name' => "Hoodie white",
            'price' => 110,
            'is_valid' => 1
        ]);
        DB::table('item')->insert([
            'name' => "Hoodie black",
            'price' => 120,
            'is_valid' => 1
        ]);
        DB::table('item')->insert([
            'name' => "Hoodie pink",
            'price' => 90,
            'is_valid' => 1
        ]);
        DB::table('item')->insert([
            'name' => "Hoodie red",
            'price' => 95,
            'is_valid' => 1
        ]);
        DB::table('item')->insert([
            'name' => "Hoodie yellow",
            'price' => 130,
            'is_valid' => 1
        ]);
    }
}
