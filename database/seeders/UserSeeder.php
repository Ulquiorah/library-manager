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
            ['email' => 'biblio@example.com'],
            [
                'name' => 'Bibliothécaire Test',
                'nom' => 'Bibliothécaire Test',
                'contact' => '06 22 22 22 22',
                'password' => bcrypt('password'),
                'role_id' => 2, // librarian
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Utilisateur Test',
                'nom' => 'Utilisateur Test',
                'contact' => '06 11 11 11 11',
                'password' => bcrypt('password'),
                'role_id' => 1, // user
            ]
        );
    }
}
