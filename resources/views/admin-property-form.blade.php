<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $property->exists ? 'Modifier le bien' : 'Ajouter un bien' }} — ImmoSpace
    </title>

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f7f8f3; color: #203a33; font-family: Arial, sans-serif; }
        a { text-decoration: none; color: inherit; }
        button, input, select, textarea { font: inherit; }
        a:focus-visible, button:focus-visible, input:focus-visible,
        select:focus-visible, textarea:focus-visible {
            outline: 3px solid #b48a55; outline-offset: 4px;
        }
        .container { max-width: 950px; padding: 0 24px; margin: auto; }
        header {
            display: flex; align-items: center; justify-content: space-between;
            gap: 20px; min-height: 90px; border-bottom: 1px solid #e1e6da;
        }
        .logo { font-size: 25px; font-weight: 800; letter-spacing: -1px; }
        .logo span { color: #b48a55; }
        .back { font-size: 13px; color: #788479; }
        main { padding: 40px 0 60px; }
        .eyebrow {
            font-size: 11px; letter-spacing: 2px; text-transform: uppercase;
            color: #947044; font-weight: bold;
        }
        h1 { font-family: Georgia, serif; font-size: 36px; font-weight: normal; margin: 12px 0; }
        .muted { color: #788479; font-size: 13px; line-height: 1.8; }
        .panel { background: white; padding: 30px; border: 1px solid #e1e6da; border-radius: 12px; margin-top: 25px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
        .full { grid-column: 1 / -1; }
        label { display: block; font-size: 13px; font-weight: bold; }
        input, select, textarea {
            display: block; width: 100%; padding: 13px; margin-top: 9px;
            border: 1px solid #dce3d6; border-radius: 6px; background: white; color: #203a33;
        }
        textarea { resize: vertical; min-height: 150px; }
        .error {
            padding: 18px; background: #fff0ec; color: #a34b3c;
            border-radius: 8px; line-height: 1.8; font-size: 13px; margin: 20px 0;
        }
        .error ul { margin: 0; padding-left: 20px; }
        .photo { width: 220px; max-width: 100%; height: 145px; object-fit: cover; border-radius: 8px; margin-top: 15px; }
        .actions { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 30px; }
        .button {
            display: inline-block; padding: 14px 22px; border: 0; border-radius: 7px;
            background: #244b3e; color: white; font-weight: bold; cursor: pointer;
        }
        .button:hover { background: #17392d; }
        .outline { color: #244b3e; background: #edf0e7; }
        .outline:hover { background: #dce5d6; }
        @media (max-width: 600px) {
            .grid { grid-template-columns: 1fr; }
            .panel { padding: 22px; }
            h1 { font-size: 30px; }
            header { flex-wrap: wrap; padding: 20px 0; }
        }
    </style>
</head>

<body>
<div class="container">
    <header>
        <a class="logo" href="{{ route('admin.dashboard') }}">
            Immo<span>Space.</span>
        </a>

        <a class="back" href="{{ route('admin.dashboard') }}">
            ← Tableau de bord
        </a>
    </header>

    <main>
        <p class="eyebrow">Gestion des biens</p>

        <h1>
            {{ $property->exists ? 'Modifier le bien' : 'Ajouter un nouveau bien' }}
        </h1>

        <p class="muted">
            Les champs marqués d’un * sont obligatoires.
        </p>

        @if ($errors->any())
            <div class="error" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <p>
                    Si vous aviez choisi une photo, sélectionnez-la à nouveau.
                </p>
            </div>
        @endif

        <form
            class="panel"
            method="POST"
            enctype="multipart/form-data"
            action="{{ $property->exists
                ? route('admin.properties.update', $property)
                : route('admin.properties.store') }}"
        >
            @csrf

            @if ($property->exists)
                @method('PUT')
            @endif

            <div class="grid">
                <div class="full">
                    <label for="title">Titre du bien *</label>
                    <input
                        id="title"
                        name="title"
                        value="{{ old('title', $property->title) }}"
                        maxlength="255"
                        placeholder="Exemple : Villa avec piscine à Marrakech"
                        required
                    >
                </div>

                <div>
                    <label for="city">Ville *</label>
                    <input
                        id="city"
                        name="city"
                        value="{{ old('city', $property->city) }}"
                        maxlength="100"
                        placeholder="Marrakech"
                        required
                    >
                </div>

                <div>
                    <label for="district">Quartier</label>
                    <input
                        id="district"
                        name="district"
                        value="{{ old('district', $property->district) }}"
                        maxlength="150"
                        placeholder="Guéliz, Targa…"
                    >
                </div>

                <div>
                    <label for="type">Type de bien *</label>
                    <select id="type" name="type" required>
                        @foreach (['Villa', 'Appartement', 'Maison', 'Terrain'] as $type)
                            <option
                                value="{{ $type }}"
                                @selected(old('type', $property->type ?? 'Villa') === $type)
                            >
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="transaction">Transaction *</label>
                    <select id="transaction" name="transaction" required>
                        @foreach (['Vente', 'Location'] as $transaction)
                            <option
                                value="{{ $transaction }}"
                                @selected(old('transaction', $property->transaction ?? 'Vente') === $transaction)
                            >
                                {{ $transaction }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="price">Prix en DH *</label>
                    <input
                        id="price"
                        name="price"
                        type="number"
                        min="0"
                        max="999999999999.99"
                        step="0.01"
                        value="{{ old('price', $property->price) }}"
                        required
                    >
                    <p class="muted">Pour une location, indiquez le loyer mensuel.</p>
                </div>

                <div>
                    <label for="area">Surface en m² *</label>
                    <input
                        id="area"
                        name="area"
                        type="number"
                        min="1"
                        max="4294967295"
                        step="1"
                        value="{{ old('area', $property->area) }}"
                        required
                    >
                </div>

                <div>
                    <label for="bedrooms">Nombre de chambres *</label>
                    <input
                        id="bedrooms"
                        name="bedrooms"
                        type="number"
                        min="0"
                        max="255"
                        step="1"
                        value="{{ old('bedrooms', $property->bedrooms ?? 0) }}"
                        required
                    >
                </div>

                <div>
                    <label for="status">Statut *</label>
                    <select id="status" name="status" required>
                        @foreach (['Disponible', 'Vendu', 'Loué'] as $status)
                            <option
                                value="{{ $status }}"
                                @selected(old('status', $property->status ?? 'Disponible') === $status)
                            >
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="full">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        maxlength="10000"
                        placeholder="Présentez le bien, ses équipements et son environnement."
                    >{{ old('description', $property->description) }}</textarea>
                </div>

                <div class="full">
                    <label for="photo">Photo du bien</label>
                    <input
                        id="photo"
                        type="file"
                        name="photo"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <p class="muted">
                        JPG, PNG ou WEBP · Maximum 5 Mo.
                        En modification, laissez ce champ vide pour garder la photo.
                    </p>

                    @if ($property->image)
                        <img
                            class="photo"
                            src="{{ $property->image }}"
                            alt="Photo actuelle du bien"
                        >
                    @endif
                </div>
            </div>

            <div class="actions">
                <button class="button" type="submit">
                    {{ $property->exists ? 'Enregistrer les modifications' : 'Ajouter le bien' }}
                </button>

                <a class="button outline" href="{{ route('admin.dashboard') }}">
                    Annuler
                </a>
            </div>
        </form>
    </main>
</div>
</body>
</html>