<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $mode === 'register'
            ? 'Créer un compte'
            : ($mode === 'login' ? 'Connexion' : 'Mon compte') }}
        — ImmoSpace
    </title>

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #faf9f6;
            color: #203a33;
            font-family: Arial, sans-serif;
        }
        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 3px solid #b48a55;
            outline-offset: 4px;
        }
        .container {
            max-width: 1100px;
            padding: 0 24px;
            margin: auto;
        }
        header {
            min-height: 90px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid #e1e6da;
        }
        .logo {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -1px;
        }
        .logo span { color: #b48a55; }
        .back { font-size: 13px; color: #788479; }
        .panel {
            max-width: 480px;
            margin: 60px auto;
            padding: 35px;
            border: 1px solid #e1e6da;
            border-radius: 14px;
            background: white;
        }
        .eyebrow {
            color: #947044;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        h1 {
            font-family: Georgia, serif;
            font-weight: normal;
            font-size: 35px;
            margin: 15px 0;
            overflow-wrap: anywhere;
        }
        .muted {
            color: #788479;
            font-size: 13px;
            line-height: 1.8;
        }
        label {
            display: block;
            margin-top: 22px;
            font-size: 13px;
            font-weight: bold;
        }
        input {
            width: 100%;
            display: block;
            margin-top: 9px;
            padding: 14px;
            border: 1px solid #dce3d6;
            border-radius: 6px;
        }
        .button {
            display: block;
            width: 100%;
            padding: 15px 20px;
            margin-top: 25px;
            border: 0;
            border-radius: 7px;
            background: #244b3e;
            color: white;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
        }
        .button:hover { background: #17392d; }
        .outline {
            background: #edf0e7;
            color: #244b3e;
        }
        .outline:hover { background: #dce5d6; }
        .switch {
            text-align: center;
            font-size: 13px;
            color: #788479;
            line-height: 1.8;
            margin-top: 25px;
        }
        .switch a { color: #947044; font-weight: bold; }
        .notice {
            padding: 15px;
            border-radius: 7px;
            font-size: 13px;
            line-height: 1.8;
            margin: 20px 0;
        }
        .error { background: #fff0ec; color: #a34b3c; }
        .success { background: #e4efdf; color: #386533; }
        .notice ul { margin: 0; padding-left: 18px; }
        .info {
            padding: 18px;
            background: #f5f6f0;
            border-radius: 8px;
            margin-top: 22px;
            overflow-wrap: anywhere;
        }
        .info strong {
            display: block;
            font-size: 12px;
            color: #788479;
            margin-bottom: 8px;
        }
        @media (max-width: 500px) {
            .panel { padding: 24px; margin: 35px auto; }
            h1 { font-size: 29px; }
        }
    </style>
</head>

<body>
<div class="container">
    <header>
        <a class="logo" href="{{ route('home') }}">
            Immo<span>Space.</span>
        </a>

        <a class="back" href="{{ route('home') }}">← Retour au site</a>
    </header>

    <main class="panel">
        <p class="eyebrow">Votre espace personnel</p>

        @if (session('success'))
            <div class="notice success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="notice error" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($mode === 'account')
            <h1>Bonjour, {{ auth()->user()->name }}.</h1>

            <p class="muted">
                Bienvenue dans votre espace client ImmoSpace.
            </p>

            <div class="info">
                <strong>Adresse email</strong>
                {{ auth()->user()->email }}
            </div>

            <div class="info">
                <strong>Membre depuis</strong>
                {{ auth()->user()->created_at->format('d/m/Y') }}
            </div>

            <a class="button" href="{{ route('home') }}#biens">
                Découvrir les biens →
            </a>

            <form method="POST" action="{{ route('client.logout') }}">
                @csrf

                <button class="button outline" type="submit">
                    Se déconnecter
                </button>
            </form>
        @else
            <h1>
                {{ $mode === 'register' ? 'Créer votre compte.' : 'Bon retour.' }}
            </h1>

            <p class="muted">
                {{ $mode === 'register'
                    ? 'Rejoignez ImmoSpace pour préparer votre projet immobilier.'
                    : 'Connectez-vous à votre espace personnel.' }}
            </p>

            <form
                method="POST"
                action="{{ $mode === 'register'
                    ? route('client.register.store')
                    : route('client.login.store') }}"
            >
                @csrf

                @if ($mode === 'register')
                    <label for="name">Nom complet</label>
                    <input
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        maxlength="150"
                        autocomplete="name"
                        required
                    >
                @endif

                <label for="email">Adresse email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    maxlength="255"
                    autocomplete="username"
                    required
                >

                <label for="password">Mot de passe</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="{{ $mode === 'register' ? 'new-password' : 'current-password' }}"
                    @if ($mode === 'register')
                        minlength="12"
                        maxlength="128"
                    @endif
                    required
                >

                @if ($mode === 'register')
                    <p class="muted">Utilisez au moins 12 caractères.</p>

                    <label for="password_confirmation">
                        Confirmer le mot de passe
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        minlength="12"
                        maxlength="128"
                        required
                    >
                @endif

                <button class="button" type="submit">
                    {{ $mode === 'register'
                        ? 'Créer mon compte →'
                        : 'Se connecter →' }}
                </button>
            </form>

            <p class="switch">
                @if ($mode === 'register')
                    Déjà un compte ?
                    <a href="{{ route('client.login') }}">Se connecter</a>
                @else
                    Pas encore de compte ?
                    <a href="{{ route('client.register') }}">Créer un compte</a>
                @endif
            </p>
        @endif
    </main>
</div>
</body>
</html>