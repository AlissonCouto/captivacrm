<?php

namespace Database\Seeders;




// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
            NicheSeeder::class,
            StatusSeeder::class,
        ]);
    }
}

/*

    CREATE DATABASE captivacrm
        DEFAULT CHARACTER SET utf8mb4
        DEFAULT COLLATE utf8mb4_general_ci;

*/
