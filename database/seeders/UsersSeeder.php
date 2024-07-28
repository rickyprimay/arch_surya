<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'wakildekan',
                'name' => 'Wakil Dekan',
                'email' => 'wadek@gmail.com',
                'password' => Hash::make('wakildekan'),
                'role' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kepalaurusan',
                'name' => 'Kepala Urusan',
                'email' => 'kaur@gmail.com',
                'password' => Hash::make('kepalaurusan'),
                'role' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'prodi',
                'name' => 'Prodi',
                'email' => 'prodi@gmail.com',
                'password' => Hash::make('prodi'),
                'role' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kelompokkeahlian',
                'name' => 'Kelompok Keahlian',
                'email' => 'Kelompok Keahlian@gmail.com',
                'password' => Hash::make('kelompokkeahlian'),
                'role' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'staf',
                'name' => 'Staf',
                'email' => 'staf@gmail.com',
                'password' => Hash::make('staf'),
                'role' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
