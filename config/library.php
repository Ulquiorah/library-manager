<?php

/**
 * Configuration du système de gestion de bibliothèque
 */

return [
    // Durée de l'emprunt en jours (par défaut)
    'borrow_duration' => env('LIBRARY_BORROW_DURATION', 30),

    // Montant de la pénalité par jour en euros
    'penalty_per_day' => env('LIBRARY_PENALTY_PER_DAY', 1),

    // Nombre de jours avant la date de retour pour envoyer un rappel
    'notification_days_before' => env('LIBRARY_NOTIFICATION_DAYS_BEFORE', 3),

    // Nombre maximum de livres qu'un utilisateur peut emprunter
    'max_books_per_user' => env('LIBRARY_MAX_BOOKS_PER_USER', 5),

    // Montant maximum de pénalité applicable à un emprunt
    'max_penalty_amount' => 50,

    // Durée d'emprunt spécifique selon la catégorie du livre
    'category_durations' => [
        'rare' => 14,      // Livres rares
        'reference' => 7,  // Livres de référence
    ],

    // Statuts possibles d'un emprunt
    'borrow_statuses' => [
        'en_cours' => 'en_cours',
        'retourne' => 'retourne',
        'retard' => 'retard',
    ],

    // Rôles utilisateur disponibles
    'roles' => [
        'user' => 1,        // Utilisateur
        'librarian' => 2,   // Bibliothécaire
        'admin' => 3,       // Admin
    ],
];
