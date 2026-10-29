<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demander une visite — ImmoSpace</title>

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #faf9f6; color: #203a33; font-family: Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }
        input, textarea, button { font: inherit; }
        a:focus-visible, input:focus-visible, textarea:focus-visible, button:focus-visible {
            outline: 3px solid #b48a55; outline-offset: 4px;
        }
        .container { max-width: 1000px; padding: 0 24px; margin: auto; }
        header { min-height: 90px; display: flex; align-items: center; justify-content: space-between; gap: 20px; border-bottom: 1px solid #e2e6dc; }
        .logo { font-size: 25px; font-weight: 800; letter-spacing: -1px; }
        .logo span { color: #b48a55; }
        .back { font-size: 13px; color: #738074; }
        main { padding: 45px 0 65px; }
        .eyebrow { color: #947044; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; font-weight: bold; }
        h1 { font-family: Georgia, serif; font-size: 38px; font-weight: normal; margin: 12px 0; }
        .muted { color: #788479; font-size: 13px; line-height: 1.8; }
        .layout { display: grid; grid-template-columns: 1.5fr 1fr; gap: 28px; margin-top: 30px; align-items: start; }
        .panel { background: white; padding: 28px; border: 1px solid #e2e6dc; border-radius: 12px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .full { grid-column: 1 / -1; }
        label { display: block; font-size: 13px; font-weight: bold; }
        input, textarea { display: block; width: 100%; border: 1px solid #dce3d6; padding: 13px; border-radius: 6px; margin-top: 9px; }
        textarea { min-height: 130px; resize: vertical; }
        .button { border: 0; border-radius: 7px; background: #244b3e; color: white; padding: 15px 22px; font-weight: bold; cursor: pointer; margin-top: 25px; }
        .button:hover { background: #17392d; }
        .notice { padding: 18px; border-radius: 8px; line-height: 1.8; font-size: 13px; margin: 20px 0; }
        .success { background: #e4efdf; color: #386533; }
        .error { background: #fff0ec; color: #a34b3c; }
        .error ul { margin: 0; padding-left: 20px; }
        .photo { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; }
        h2 { font-size: 21px; margin: 20px 0 10px; }
        .price { font-size: 22px; color: #244b3e; font-weight: bold; }
        .summary { font-size: 13px; color: #788479; line-height: 1.8; }
        @media (max-width: 700px) {
            .layout, .grid { grid-template-columns: 1fr; }
            h1 { font-size: 31px; }
            .panel { padding: 22px; }
            header { flex-wrap: wrap; padding: 20px 0; }
        }
    </style>
</head>

<body>
<div class="container">
    <header>
        <a class="logo" href="{{ route('home') }}">Immo<span>Space.</span></a>
        <a class="back" href="{{ route('properties.show', $property) }}">← Retour au bien</a>
    </header>

    <main>
        <p class="eyebrow">Parlons de votre projet</p>
        <h1>Organiser une visite.</h1>
        <p class="muted">Indiquez vos coordonnées et la date souhaitée. Les champs * sont obligatoires.</p>

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

        <div class="layout">
            <form class="panel" method="POST" action="{{ route('visits.store', $property) }}">
                @csrf

                <div class="grid">
                    <div class="full">
                        <label for="name">Nom complet *</label>
                        <input
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            maxlength="150"
                            autocomplete="name"
                            required
                        >
                    </div>

                    <div>
                        <label for="email">Email *</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            maxlength="255"
                            autocomplete="email"
                            required
                        >
                    </div>

                    <div>
                        <label for="phone">Téléphone *</label>
                        <input
                            id="phone"
                            type="tel"
                            name="phone"
                            value="{{ old('phone') }}"
                            minlength="6"
                            maxlength="30"
                            autocomplete="tel"
                            required
                        >
                    </div>

                    <div class="full">
                        <label for="preferred_date">Date souhaitée</label>
                        <input
                            id="preferred_date"
                            type="date"
                            name="preferred_date"
                            min="{{ now()->toDateString() }}"
                            value="{{ old('preferred_date') }}"
                        >
                    </div>

                    <div class="full">
                        <label for="message">Votre message</label>
                        <textarea
                            id="message"
                            name="message"
                            maxlength="3000"
                            placeholder="Précisez vos disponibilités ou posez vos questions."
                        >{{ old('message') }}</textarea>
                    </div>
                </div>

                <p class="muted">
                    Vos coordonnées seront accessibles à l’administrateur
                    pour le suivi de votre demande. Aucun email automatique
                    n’est envoyé à cette étape.
                </p>

                <button class="button" type="submit">Envoyer ma demande →</button>
            </form>

            <aside class="panel">
                <img
                    class="photo"
                    src="{{ $property->image ?: '/images/villa-marrakech.jpg' }}"
                    alt="{{ $property->title }}"
                >

                <h2>{{ $property->title }}</h2>

                <p class="summary">
                    {{ $property->city }}
                    @if ($property->district)
                        · {{ $property->district }}
                    @endif
                </p>

                <p class="price">
                    {{ number_format((float) $property->price, 0, ',', ' ') }} DH
                    @if ($property->transaction === 'Location')
                        <small>/ mois</small>
                    @endif
                </p>

                <p class="summary">
                    {{ $property->area }} m² · {{ $property->type }}
                    <br>
                    Référence IMM-{{ str_pad((string) $property->id, 4, '0', STR_PAD_LEFT) }}
                </p>

                <p class="muted">
                    Votre demande ne constitue pas une réservation.
                    La date sera confirmée par l’agence.
                </p>
            </aside>
        </div>
    </main>
</div>
</body>
</html>