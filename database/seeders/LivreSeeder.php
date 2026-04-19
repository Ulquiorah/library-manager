<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LivreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livres = [
            [
                'titre' => 'Le Petit Prince',
                'auteur' => 'Antoine de Saint-Exupéry',
                'isbn' => '978-2-07-040850-4',
                'description' => 'Un conte philosophique pour enfants et adultes',
                'categorie' => 'Conte',
                'date_publication' => '1943-04-06',
                'quantite' => 5,
                'quantite_disponible' => 5,
                'resume' => 'Le Petit Prince est un conte philosophique écrit par Antoine de Saint-Exupéry. Il raconte l\'histoire d\'un aviateur qui rencontre un petit prince venu d\'une autre planète.',
                'editeur' => 'Gallimard',
            ],
            [
                'titre' => '1984',
                'auteur' => 'George Orwell',
                'isbn' => '978-2-07-036822-8',
                'description' => 'Un roman dystopique sur la surveillance et le totalitarisme',
                'categorie' => 'Science-fiction',
                'date_publication' => '1949-06-08',
                'quantite' => 3,
                'quantite_disponible' => 3,
                'resume' => '1984 est un roman dystopique de George Orwell décrivant une société totalitaire où la surveillance est omniprésente et la liberté individuelle inexistante.',
                'editeur' => 'Gallimard',
            ],
            [
                'titre' => 'Harry Potter à l\'école des sorciers',
                'auteur' => 'J.K. Rowling',
                'isbn' => '978-2-07-051842-5',
                'description' => 'Le premier tome de la saga Harry Potter',
                'categorie' => 'Fantastique',
                'date_publication' => '1997-06-26',
                'quantite' => 4,
                'quantite_disponible' => 4,
                'resume' => 'Harry Potter découvre qu\'il est un sorcier et est invité à étudier à Poudlard, l\'école de magie.',
                'editeur' => 'Gallimard Jeunesse',
            ],
            [
                'titre' => 'Les Misérables',
                'auteur' => 'Victor Hugo',
                'isbn' => '978-2-07-040450-6',
                'description' => 'Un roman historique sur la société française du XIXe siècle',
                'categorie' => 'Roman historique',
                'date_publication' => '1862-01-01',
                'quantite' => 2,
                'quantite_disponible' => 2,
                'resume' => 'Les Misérables raconte l\'histoire de Jean Valjean, un ancien bagnard qui cherche la rédemption dans la France du XIXe siècle.',
                'editeur' => 'Gallimard',
            ],
            [
                'titre' => 'Le Seigneur des Anneaux',
                'auteur' => 'J.R.R. Tolkien',
                'isbn' => '978-2-266-11105-9',
                'description' => 'La trilogie épique de la Terre du Milieu',
                'categorie' => 'Fantastique',
                'date_publication' => '1954-07-29',
                'quantite' => 3,
                'quantite_disponible' => 3,
                'resume' => 'Le Seigneur des Anneaux est une trilogie fantastique racontant la quête de Frodon pour détruire l\'Anneau Unique.',
                'editeur' => 'Christian Bourgois',
            ],
            [
                'titre' => 'Dune',
                'auteur' => 'Frank Herbert',
                'isbn' => '978-2-207-10835-8',
                'description' => 'Un classique de la science-fiction',
                'categorie' => 'Science-fiction',
                'date_publication' => '1965-08-01',
                'quantite' => 2,
                'quantite_disponible' => 2,
                'resume' => 'Dune raconte l\'histoire de Paul Atréides sur la planète désertique Arrakis.',
                'editeur' => 'Robert Laffont',
            ],
        ];

        foreach ($livres as $livre) {
            \App\Models\Livre::firstOrCreate(
                ['isbn' => $livre['isbn']],
                $livre
            );
        }
    }
}