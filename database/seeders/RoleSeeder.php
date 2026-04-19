<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier et insérer les rôles uniquement s'ils n'existent pas
        \App\Models\Role::firstOrCreate(
            ['id' => 1],
            ['type' => 'user', 'description' => 'Utilisateur simple']
        );
        \App\Models\Role::firstOrCreate(
            ['id' => 2],
            ['type' => 'librarian', 'description' => 'Bibliothécaire']
        );
    }
}
