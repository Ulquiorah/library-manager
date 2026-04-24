@extends('layouts.app')

@section('title', 'Catégories')
@section('main_class', 'py-0')
@section('footer_class', 'mt-0')

@section('content')
<div class="container-fluid dashboard-layout px-0">
    <div class="row g-0">
        <div class="col-lg-3 col-xl-2 pe-lg-3 mb-3 mb-lg-0">
            @include('dashboard.partials.sidebar')
        </div>

        <div class="col-lg-9 col-xl-10 px-3 px-lg-4">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h1 class="h2 mb-0">Gestion des catégories</h1>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Ajouter une catégorie</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST" class="row g-2">
                        @csrf
                        <div class="col-md-8">
                            <input
                                type="text"
                                name="nom"
                                class="form-control @error('nom') is-invalid @enderror"
                                placeholder="Nom de la catégorie"
                                value="{{ old('nom') }}"
                                required
                            >
                            @error('nom')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 d-grid">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Liste des catégories</h5>
                </div>
                <div class="card-body">
                    @if($categories->isEmpty())
                        <p class="text-muted mb-0">Aucune catégorie disponible.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Catégorie</th>
                                        <th>Nombre de livres</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>
                                                <form action="{{ route('categories.update', $category) }}" method="POST" class="d-flex gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input
                                                        type="text"
                                                        name="nom"
                                                        class="form-control form-control-sm"
                                                        value="{{ $category->nom }}"
                                                        required
                                                    >
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">Modifier</button>
                                                </form>
                                            </td>
                                            <td>{{ $category->livres_count }}</td>
                                            <td>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
