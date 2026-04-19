<?php

/**
 * Configuration du système de gestion de bibliothèque
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Durée de l'emprunt (en jours)
    |--------------------------------------------------------------------------
    | Nombre de jours par défaut pour emprunter un livre
    */
    'borrow_duration' => env('LIBRARY_BORROW_DURATION', 30),

    /*
    |--------------------------------------------------------------------------
    | Montant de la pénalité par jour (en €)
    |--------------------------------------------------------------------------
    | Montant appliqué par jour de retard
    */
    'penalty_per_day' => env('LIBRARY_PENALTY_PER_DAY', 1),

    /*
    |--------------------------------------------------------------------------
    | Jours avant le retour pour notification
    |--------------------------------------------------------------------------
    | Nombre de jours avant la date de retour pour envoyer un rappel
    */
    'notification_days_before' => env('LIBRARY_NOTIFICATION_DAYS_BEFORE', 3),

    /*
    |--------------------------------------------------------------------------
    | Nombre maximum de livres par utilisateur
    |--------------------------------------------------------------------------
    | Nombre maximum de livres qu'un utilisateur peut emprunter simultanément
    */
    'max_books_per_user' => env('LIBRARY_MAX_BOOKS_PER_USER', 5),

    /*
    |--------------------------------------------------------------------------
    | Montant maximum de pénalité
    |--------------------------------------------------------------------------
    | Montant maximum de pénalité qui peut être appliqué à un emprunt
    */
    'max_penalty_amount' => 50,

    /*
    |--------------------------------------------------------------------------
    | Réductions basées sur les catégories
    |--------------------------------------------------------------------------
    | Durée d'emprunt spécifique pour certaines catégories (ex: livres rares)
    */
    'category_durations' => [
        'rare' => 14,      // Les livres rares: 14 jours
        'reference' => 7,  // Les livres de référence: 7 jours
    ],

    /*
    |--------------------------------------------------------------------------
    | Statuts d'emprunt
    |--------------------------------------------------------------------------
    */
    'borrow_statuses' => [
        'en_cours' => 'en_cours',
        'retourne' => 'retourne',
        'retard' => 'retard',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rôles utilisateur
    |--------------------------------------------------------------------------
    */
    'roles' => [
        'user' => 1,        // Utilisateur normal
        'librarian' => 2,   // Bibliothécaire
        'admin' => 3,       // Administrateur
    ],
];
