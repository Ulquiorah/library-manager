@extends('layouts.app')

@section('title', 'Ajouter un livre')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Ajouter un nouveau livre</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('livres.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titre" class="form-label">Titre *</label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror"
                                       id="titre" name="titre" value="{{ old('titre') }}" required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="auteur" class="form-label">Auteur *</label>
                                <input type="text" class="form-control @error('auteur') is-invalid @enderror"
                                       id="auteur" name="auteur" value="{{ old('auteur') }}" required>
                                @error('auteur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                       id="isbn" name="isbn" value="{{ old('isbn') }}">
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="categorie" class="form-label">Catégorie</label>
                                <select class="form-select @error('categorie') is-invalid @enderror" id="categorie" name="categorie">
                                    <option value="">-- Sélectionner une catégorie --</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->nom }}" {{ old('categorie') === $categorie->nom ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_publication" class="form-label">Date de publication</label>
                                <input type="date" class="form-control @error('date_publication') is-invalid @enderror"
                                       id="date_publication" name="date_publication" value="{{ old('date_publication') }}">
                                @error('date_publication')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="quantite" class="form-label">Quantité *</label>
                                <input type="number" class="form-control @error('quantite') is-invalid @enderror"
                                       id="quantite" name="quantite" value="{{ old('quantite', 1) }}" min="1" required>
                                @error('quantite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo du livre</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                   id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Formats acceptés : JPEG, PNG, JPG, GIF. Taille maximale : 2 Mo.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editeur" class="form-label">Éditeur</label>
                            <input type="text" class="form-control @error('editeur') is-invalid @enderror"
                                   id="editeur" name="editeur" value="{{ old('editeur') }}">
                            @error('editeur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="resume" class="form-label">Résumé</label>
                            <textarea class="form-control @error('resume') is-invalid @enderror"
                                      id="resume" name="resume" rows="4">{{ old('resume') }}</textarea>
                            @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('livres.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer le livre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection