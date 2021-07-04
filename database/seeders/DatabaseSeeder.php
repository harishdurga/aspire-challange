<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!\App\Models\User::find(1)) {
            \App\Models\User::factory(1)->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => 'Test@2022'
            ]);
        }
    }
}
