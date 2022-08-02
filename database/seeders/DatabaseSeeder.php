<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;


final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
         $this->call([
             AdminSeeder::class,
             UserSeeder::class,
             Brand::class,
         ]);
    }
}
