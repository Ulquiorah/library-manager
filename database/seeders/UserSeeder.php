<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nom' => 'Admin Test',
                'contact' => '06 00 00 00 00',
                'password' => bcrypt('password'),
                'role_id' => 3, // admin
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'nom' => 'Utilisateur Test',
                'contact' => '06 11 11 11 11',
                'password' => bcrypt('password'),
                'role_id' => 1, // user
            ]
        );
    }
}
