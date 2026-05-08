@extends('layouts.app')

@section('title', 'Modifier le livre')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/livres-edit.css') }}" type="text/css">
@endpush

@section('content')
<div class="livres-edit-container">
    <!-- Header -->
    <div class="edit-header">
        <h1 class="edit-title">
            <i class="fas fa-edit"></i>
            Modifier le livre : {{ $livre->titre }}
        </h1>
    </div>

    <!-- Formulaire -->
    <div class="edit-form-container">
    <form action="{{ route('livres.update', $livre) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Section Informations principales -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-info-circle"></i>
                Informations principales
            </h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="titre" class="form-label">
                            <i class="fas fa-heading"></i>
                            Titre *
                        </label>
                        <input type="text" class="form-control @error('titre') is-invalid @enderror"
                               id="titre" name="titre" value="{{ old('titre', $livre->titre) }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="auteur" class="form-label">
                            <i class="fas fa-user-edit"></i>
                            Auteur *
                        </label>
                        <input type="text" class="form-control @error('auteur') is-invalid @enderror"
                               id="auteur" name="auteur" value="{{ old('auteur', $livre->auteur) }}" required>
                        @error('auteur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Détails -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-book"></i>
                Détails du livre
            </h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="isbn" class="form-label">
                            <i class="fas fa-barcode"></i>
                            ISBN
                        </label>
                        <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                               id="isbn" name="isbn" value="{{ old('isbn', $livre->isbn) }}">
                        @error('isbn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="categorie" class="form-label">
                            <i class="fas fa-tag"></i>
                            Catégorie
                        </label>
                        <select class="form-select @error('categorie') is-invalid @enderror" id="categorie" name="categorie">
                            <option value="">-- Sélectionner une catégorie --</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->nom }}" {{ old('categorie', $livre->categorie) === $categorie->nom ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date_publication" class="form-label">
                            <i class="fas fa-calendar"></i>
                            Date de publication
                        </label>
                        <input type="date" class="form-control @error('date_publication') is-invalid @enderror"
                               id="date_publication" name="date_publication"
                               value="{{ old('date_publication', $livre->date_publication ? $livre->date_publication->format('Y-m-d') : '') }}">
                        @error('date_publication')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Stock -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-warehouse"></i>
                Gestion du stock
            </h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantite" class="form-label">
                            <i class="fas fa-boxes"></i>
                            Quantité *
                        </label>
                        <input type="number" class="form-control @error('quantite') is-invalid @enderror"
                               id="quantite" name="quantite" value="{{ old('quantite', $livre->quantite) }}" min="1" required>
                        @error('quantite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Actuellement : {{ $livre->quantite_disponible }} disponibles sur {{ $livre->quantite }} total
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="editeur" class="form-label">
                            <i class="fas fa-building"></i>
                            Éditeur
                        </label>
                        <input type="text" class="form-control @error('editeur') is-invalid @enderror"
                               id="editeur" name="editeur" value="{{ old('editeur', $livre->editeur) }}">
                        @error('editeur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Image -->
        <div class="form-section image-section">
            <h3 class="section-title">
                <i class="fas fa-image"></i>
                Photo du livre
            </h3>
            @if($livre->photo)
                <div class="image-preview">
                    <img src="{{ asset('storage/' . $livre->photo) }}" alt="{{ $livre->titre }}" class="img-thumbnail">
                </div>
            @endif
            <div class="form-group">
                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                       id="photo" name="photo" accept="image/*">
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">
                    <i class="fas fa-file-image"></i>
                    Formats acceptés : JPEG, PNG, JPG, GIF. Taille maximale : 2 Mo.
                    @if($livre->photo)
                        <br><i class="fas fa-info-circle"></i> Laissez vide pour conserver l'image actuelle.
                    @endif
                </div>
            </div>
        </div>

        <!-- Section Description -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-align-left"></i>
                Contenu
            </h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="fas fa-file-alt"></i>
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4">{{ old('description', $livre->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="resume" class="form-label">
                            <i class="fas fa-clipboard"></i>
                            Résumé
                        </label>
                        <textarea class="form-control @error('resume') is-invalid @enderror"
                                  id="resume" name="resume" rows="4">{{ old('resume', $livre->resume) }}</textarea>
                        @error('resume')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Actions -->
        <div class="form-actions">
            <a href="{{ route('livres.show', $livre) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection