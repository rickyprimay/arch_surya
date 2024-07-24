<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('division')->insert([
            [
                'name' => 'SDM', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Keuangan', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Logistik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
