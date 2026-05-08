@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h1 class="text-center h3 mb-4 text-primary">Connexion</h1>
                    
                    <form method="POST" action="{{ route('login') }}" class="needs-validation">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                            @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-4">
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
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            Se connecter
                        </button>
                    </form>

                    <hr>

                    <p class="text-center mb-0">
                        Vous n'avez pas de compte ?
                        <a href="{{ route('register') }}" class="text-primary">S'inscrire</a>
                    </p>
                </div>
            </div>

            <!-- <div class="alert alert-info mt-4" role="alert">
                <strong>Compte de test :</strong><br>
                Email: admin@example.com<br>
                Mot de passe: password
            </div> -->
        </div>
    </div>
</div>
@endsection
