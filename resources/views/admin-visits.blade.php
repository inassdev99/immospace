<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de visite — ImmoSpace</title>

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f7f8f3; color: #203a33; font-family: Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }
        select, button { font: inherit; }
        a:focus-visible, select:focus-visible, button:focus-visible {
            outline: 3px solid #b48a55; outline-offset: 4px;
        }
        .container { max-width: 1120px; margin: auto; padding: 0 24px; }
        header { min-height: 90px; display: flex; align-items: center; justify-content: space-between; gap: 20px; border-bottom: 1px solid #e2e6dc; }
        .logo { font-size: 25px; font-weight: 800; letter-spacing: -1px; }
        .logo span { color: #b48a55; }
        .back { font-size: 13px; color: #738074; }
        main { padding: 40px 0 60px; }
        .eyebrow { color: #947044; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; font-weight: bold; }
        h1 { font-family: Georgia, serif; font-size: 36px; font-weight: normal; margin: 12px 0; }
        .muted { color: #788479; font-size: 13px; line-height: 1.8; }
        .card { padding: 25px; background: white; border: 1px solid #e2e6dc; border-radius: 12px; margin-top: 22px; }
        .top { display: flex; justify-content: space-between; align-items: start; gap: 20px; }
        h2 { font-size: 19px; margin: 0 0 10px; }
        .badge { padding: 8px 12px; border-radius: 5px; background: #eaf0e5; font-size: 12px; white-space: nowrap; }
        .details { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin: 22px 0; }
        .details p { margin: 0; font-size: 14px; line-height: 1.8; overflow-wrap: anywhere; }
        .details strong { display: block; color: #788479; font-size: 12px; font-weight: normal; }
        .message { background: #f6f7f1; border-radius: 7px; padding: 16px; font-size: 14px; line-height: 1.8; white-space: pre-line; overflow-wrap: anywhere; }
        .status-form { display: flex; flex-wrap: wrap; align-items: end; gap: 12px; margin-top: 20px; }
        label { font-size: 12px; font-weight: bold; }
        select { display: block; margin-top: 8px; padding: 11px; border: 1px solid #dce3d6; border-radius: 6px; background: white; }
        .button { border: 0; border-radius: 6px; padding: 12px 18px; background: #244b3e; color: white; cursor: pointer; }
        .success { padding: 16px; margin: 20px 0; border-radius: 7px; background: #e4efdf; color: #386533; font-size: 13px; }
        .error { padding: 16px; margin: 20px 0; border-radius: 7px; background: #fff0ec; color: #a34b3c; font-size: 13px; }
        .link { color: #947044; font-size: 13px; font-weight: bold; }
        .pagination { display: flex; justify-content: space-between; gap: 20px; margin-top: 30px; font-size: 13px; }
        .pagination div { display: flex; gap: 18px; }
        @media (max-width: 600px) {
            .details { grid-template-columns: 1fr; }
            .card { padding: 20px; }
            h1 { font-size: 29px; }
            header { flex-wrap: wrap; padding: 20px 0; }
        }
    </style>
</head>

<body>
<div class="container">
    <header>
        <a class="logo" href="{{ route('admin.dashboard') }}">Immo<span>Space.</span></a>
        <a class="back" href="{{ route('admin.dashboard') }}">← Tableau de bord</a>
    </header>

    <main>
        <p class="eyebrow">Relation clients</p>
        <h1>Demandes de visite.</h1>

        <p class="muted">
            {{ $visits->total() }} demande(s) au total ·
            {{ $newCount }} nouvelle(s).
        </p>

        @if (session('success'))
            <div class="success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @forelse ($visits as $visit)
            <article class="card">
                <div class="top">
                    <div>
                        <h2>{{ $visit->property_title }}</h2>
                        <p class="muted">
                            Demande #{{ $visit->id }} ·
                            Reçue le {{ $visit->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <span class="badge">{{ $visit->status }}</span>
                </div>

                <div class="details">
                    <p>
                        <strong>Client</strong>
                        {{ $visit->name }}
                    </p>

                    <p>
                        <strong>Email</strong>
                        {{ $visit->email }}
                    </p>

                    <p>
                        <strong>Téléphone</strong>
                        {{ $visit->phone }}
                    </p>

                    <p>
                        <strong>Date souhaitée</strong>
                        {{ $visit->preferred_date?->format('d/m/Y') ?? 'Non précisée' }}
                    </p>
                </div>

                @if ($visit->message)
                    <div class="message">{{ $visit->message }}</div>
                @endif

                @if ($visit->property && $visit->property->status === 'Disponible')
                    <p>
                        <a class="link" href="{{ route('properties.show', $visit->property) }}">
                            Voir le bien ↗
                        </a>
                    </p>
                @else
                    <p class="muted">Ce bien a été retiré du catalogue public.</p>
                @endif

                <form
                    class="status-form"
                    method="POST"
                    action="{{ route('admin.visits.update', $visit) }}"
                >
                    @csrf
                    @method('PATCH')

                    <label for="status-{{ $visit->id }}">
                        Statut de la demande

                        <select id="status-{{ $visit->id }}" name="status" required>
                            @foreach (['Nouveau', 'En cours', 'Traité', 'Annulé'] as $status)
                                <option value="{{ $status }}" @selected($visit->status === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <button class="button" type="submit">Enregistrer</button>
                </form>
            </article>
        @empty
            <div class="card">
                <p class="muted">Aucune demande de visite pour le moment.</p>
            </div>
        @endforelse

        @if ($visits->hasPages())
            <div class="pagination">
                <span>
                    Page {{ $visits->currentPage() }}
                    sur {{ $visits->lastPage() }}
                </span>

                <div>
                    @if (! $visits->onFirstPage())
                        <a href="{{ $visits->previousPageUrl() }}">← Précédent</a>
                    @endif

                    @if ($visits->hasMorePages())
                        <a href="{{ $visits->nextPageUrl() }}">Suivant →</a>
                    @endif
                </div>
            </div>
        @endif
    </main>
</div>
</body>
</html>