<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration — ImmoSpace</title>

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f7f8f3; color: #203a33; font-family: Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 3px solid #b48a55; outline-offset: 4px;
        }
        .container { max-width: 1250px; padding: 0 24px; margin: auto; }
        header {
            display: flex; justify-content: space-between; align-items: center;
            gap: 20px; min-height: 90px; border-bottom: 1px solid #e1e6da;
        }
        .logo { font-size: 25px; font-weight: 800; letter-spacing: -1px; }
        .logo span { color: #b48a55; }
        .nav { display: flex; align-items: center; gap: 20px; font-size: 13px; }
        form { margin: 0; }
        .button {
            display: inline-block; border: none; border-radius: 7px;
            padding: 13px 20px; background: #244b3e; color: white;
            font-weight: bold; text-align: center; cursor: pointer;
        }
        .button:hover { background: #17392d; }
        .outline { background: transparent; color: #244b3e; border: 1px solid #cad5c7; }
        .outline:hover { background: #e7ede3; }
        .login {
            max-width: 450px; margin: 75px auto; padding: 38px;
            border: 1px solid #e1e6da; border-radius: 14px; background: white;
        }
        .eyebrow {
            font-size: 11px; letter-spacing: 2px; text-transform: uppercase;
            color: #947044; font-weight: bold;
        }
        h1 { font-family: Georgia, serif; font-size: 36px; font-weight: normal; margin: 12px 0; }
        .muted { color: #788479; font-size: 14px; line-height: 1.8; }
        label { display: block; margin-top: 24px; font-size: 13px; font-weight: bold; }
        input {
            display: block; width: 100%; margin-top: 9px; padding: 14px;
            border: 1px solid #dce3d6; border-radius: 6px; background: white;
        }
        .login .button { width: 100%; margin-top: 28px; }
        .error, .success {
            padding: 16px; margin: 20px 0; border-radius: 7px;
            font-size: 13px; line-height: 1.7;
        }
        .error { background: #fff0ec; color: #a34b3c; }
        .success { background: #e4efdf; color: #386533; }
        .heading {
            padding: 40px 0 25px; display: flex; align-items: center;
            justify-content: space-between; gap: 20px;
        }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 35px; }
        .stat { padding: 25px; border: 1px solid #e1e6da; border-radius: 10px; background: white; }
        .stat span { color: #788479; font-size: 13px; }
        .stat strong { display: block; margin-top: 15px; font-size: 34px; font-weight: normal; }
        .panel { background: white; border: 1px solid #e1e6da; border-radius: 12px; padding: 25px; margin-bottom: 40px; }
        h2 { font-size: 19px; margin: 0 0 22px; }
        .table-scroll { overflow-x: auto; }
        table { border-collapse: collapse; width: 100%; font-size: 13px; }
        th, td { padding: 16px 10px; border-bottom: 1px solid #edf0e7; text-align: left; }
        th { background: #f6f8f2; color: #788479; font-size: 11px; text-transform: uppercase; }
        .property { display: flex; align-items: center; gap: 12px; min-width: 220px; }
        .property img { width: 70px; height: 52px; object-fit: cover; border-radius: 6px; background: #e7e7df; }
        .property small { display: block; color: #788479; margin-top: 6px; }
        .badge { display: inline-block; padding: 7px 10px; border-radius: 5px; background: #eaf0e5; white-space: nowrap; }
        .actions { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; min-width: 190px; }
        .action {
            display: inline-block; padding: 8px 10px; border: 0; border-radius: 5px;
            font-size: 12px; cursor: pointer; background: #edf0e7; color: #244b3e;
        }
        .danger { background: #fbeae6; color: #a34b3c; }
        .pagination { display: flex; justify-content: space-between; gap: 20px; margin-top: 24px; font-size: 13px; }
        .pagination div { display: flex; gap: 18px; }
        @media (max-width: 800px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
            .heading { flex-direction: column; align-items: start; }
        }
        @media (max-width: 500px) {
            header { flex-wrap: wrap; padding: 20px 0; }
            .nav { gap: 15px; flex-wrap: wrap; }
            .login { padding: 25px; margin: 40px auto; }
            h1 { font-size: 30px; }
            .stat { padding: 18px; }
            .panel { padding: 16px; }
        }
    </style>
</head>

<body>
<div class="container">
    <header>
        <a class="logo" href="{{ route('home') }}">
            Immo<span>Space.</span>
        </a>

        
            <nav class="nav" aria-label="Navigation administration">
                @if (! $showLogin)
                    <a data-admin-visits-link href="{{ route('admin.visits.index') }}">
                        Demandes de visite
                    </a>
                @endif
        
            <a href="{{ route('home') }}">Voir le site ↗</a>

            @if (! $showLogin)
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="button outline" type="submit">
                        Déconnexion
                    </button>
                </form>
            @endif
        </nav>
    </header>

    <main>
        @if ($showLogin)
            <section class="login">
                <p class="eyebrow">Espace administrateur</p>
                <h1>Bon retour.</h1>
                <p class="muted">Connectez-vous pour gérer votre agence.</p>

                @if ($errors->any())
                    <div class="error" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <label for="email">Adresse email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        required
                        autofocus
                    >

                    <label for="password">Mot de passe</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >

                    <button class="button" type="submit">
                        Se connecter →
                    </button>
                </form>
            </section>
        @else
            <section class="heading">
                <div>
                    <p class="eyebrow">Administration</p>
                    <h1>Bonjour, {{ auth()->user()->name }}.</h1>
                    <p class="muted">Gérez votre portefeuille immobilier.</p>
                </div>

                <a class="button" href="{{ route('admin.properties.create') }}">
                    + Ajouter un bien
                </a>
            </section>

            @if (session('success'))
                <div class="success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            <section class="stats" aria-label="Statistiques">
                <div class="stat">
                    <span>Total des biens</span>
                    <strong>{{ $total }}</strong>
                </div>
                <div class="stat">
                    <span>Disponibles</span>
                    <strong>{{ $available }}</strong>
                </div>
                <div class="stat">
                    <span>À vendre</span>
                    <strong>{{ $sales }}</strong>
                </div>
                <div class="stat">
                    <span>À louer</span>
                    <strong>{{ $rentals }}</strong>
                </div>
            </section>

            <section class="panel">
                <h2>Vos biens immobiliers</h2>

                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Bien</th>
                                <th scope="col">Transaction</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($properties as $property)
                                <tr>
                                    <td>
                                        <div class="property">
                                            <img
                                                src="{{ $property->image ?: '/images/villa-marrakech.jpg' }}"
                                                alt=""
                                            >
                                            <div>
                                                <strong>{{ $property->title }}</strong>
                                                <small>
                                                    {{ $property->city }}
                                                    · {{ $property->type }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ $property->transaction }}</td>

                                    <td>
                                        {{ number_format((float) $property->price, 0, ',', ' ') }} DH
                                        @if ($property->transaction === 'Location')
                                            / mois
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge">{{ $property->status }}</span>
                                    </td>

                                    <td>
                                        <div class="actions">
                                            @if ($property->status === 'Disponible')
                                                <a
                                                    class="action"
                                                    href="{{ route('properties.show', $property) }}"
                                                >
                                                    Voir
                                                </a>
                                            @endif

                                            <a
                                                class="action"
                                                href="{{ route('admin.properties.edit', $property) }}"
                                            >
                                                Modifier
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.properties.destroy', $property) }}"
                                                onsubmit="return confirm('Supprimer définitivement ce bien ?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button class="action danger" type="submit">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Aucun bien enregistré.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($properties->hasPages())
                    <div class="pagination">
                        <span>
                            Page {{ $properties->currentPage() }}
                            sur {{ $properties->lastPage() }}
                        </span>

                        <div>
                            @if (! $properties->onFirstPage())
                                <a href="{{ $properties->previousPageUrl() }}">← Précédent</a>
                            @endif

                            @if ($properties->hasMorePages())
                                <a href="{{ $properties->nextPageUrl() }}">Suivant →</a>
                            @endif
                        </div>
                    </div>
                @endif
            </section>
        @endif
    </main>
</div>
</body>
</html>