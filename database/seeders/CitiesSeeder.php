<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            ['name' => 'Bandung'],
            ['name' => 'Jakarta'],
            ['name' => 'Surabaya'],
            ['name' => 'Purwokerto'],
        ]);
    }
}
