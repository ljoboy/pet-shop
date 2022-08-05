<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

final class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'last_name' => fake()->name(),
            'first_name' => fake()->firstName(),
            'email' => 'admin@buckhill.co.uk',
            'email_verified_at' => now(),
            'password' => 'admin',
            'address' => fake()->address(),
            'phone_number' => fake()->e164PhoneNumber(),
            'is_admin' => true,
        ]);
    }
}
