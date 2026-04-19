@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col="lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h1 class="text-center h3 mb-4 text-primary">✍️ S'inscrire</h1>
                    
                    <form method="POST" action="{{ route('register') }}" class="needs-validation">
                        @csrf

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom complet</label>
                            <input 
                                type="text" 
                                class="form-control @error('nom') is-invalid @enderror" 
                                id="nom" 
                                name="nom" 
                                value="{{ old('nom') }}"
                                required
                                autofocus
                            >
                            @error('nom')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact (Téléphone)</label>
                            <input 
                                type="tel" 
                                class="form-control @error('contact') is-invalid @enderror" 
                                id="contact" 
                                name="contact" 
                                value="{{ old('contact') }}"
                                required
                            >
                            @error('contact')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                required
                            >
                            @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                            <small class="text-muted">Minimum 8 caractères</small>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input 
                                type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required
                            >
                            @error('password_confirmation')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            S'inscrire
                        </button>
                    </form>

                    <hr>

                    <p class="text-center mb-0">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}" class="text-primary">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
