<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Processor'],
            ['name' => 'Graphics Card'],
            ['name' => 'Motherboard'],
            ['name' => 'Memory'],
            ['name' => 'Storage'],
            ['name' => 'Power Supply'],
            ['name' => 'PC Case'],
            ['name' => 'CPU Cooler'],
        ]);
    }
}