<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $property->title }} — ImmoSpace</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #faf9f6;
            color: #203a33;
            font-family: Arial, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        a:focus-visible {
            outline: 3px solid #b48a55;
            outline-offset: 5px;
        }

        .container {
            max-width: 1140px;
            margin: auto;
            padding: 0 24px;
        }

        header {
            min-height: 90px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 1px solid #e6e8df;
        }

        .logo {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .logo span {
            color: #b48a55;
        }

        .back {
            font-size: 14px;
            color: #637367;
        }

        main {
            padding: 35px 0 65px;
        }

        .breadcrumb {
            font-size: 13px;
            color: #788479;
            margin-bottom: 25px;
        }

        .breadcrumb a {
            text-decoration: underline;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 25px;
            margin-bottom: 30px;
        }

        .badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 5px;
            background: #e8eee5;
            color: #244b3e;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        h1 {
            font-family: Georgia, serif;
            font-size: clamp(32px, 5vw, 48px);
            font-weight: normal;
            margin: 0 0 12px;
        }

        .location {
            color: #788479;
            font-size: 15px;
            margin: 0;
        }

        .price {
            color: #244b3e;
            font-size: 30px;
            font-weight: bold;
            white-space: nowrap;
        }

        .price small {
            font-size: 14px;
            font-weight: normal;
            color: #788479;
        }

        .cover {
            width: 100%;
            height: 480px;
            object-fit: cover;
            display: block;
            background: #e7e7df;
            border-radius: 14px;
        }

        .photo-note {
            font-size: 12px;
            color: #788479;
            margin: 12px 0 30px;
        }

        .layout {
            display: grid;
            grid-template-columns: 1.7fr 1fr;
            gap: 28px;
            align-items: start;
        }

        .panel {
            border: 1px solid #e4e8df;
            border-radius: 12px;
            padding: 30px;
            background: white;
        }

        h2 {
            font-family: Georgia, serif;
            font-size: 27px;
            font-weight: normal;
            margin: 0 0 22px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .feature {
            background: #f5f6f0;
            padding: 20px 12px;
            border-radius: 8px;
            text-align: center;
        }

        .feature strong {
            display: block;
            font-size: 21px;
            margin-bottom: 8px;
        }

        .feature span {
            color: #788479;
            font-size: 12px;
        }

        .description {
            color: #69766c;
            font-size: 15px;
            line-height: 1.9;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .details {
            margin: 0;
        }

        .detail {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #eef0e9;
            font-size: 14px;
        }

        .detail dt {
            color: #788479;
        }

        .detail dd {
            margin: 0;
            text-align: right;
            font-weight: bold;
        }

        .notice {
            margin-top: 25px;
            padding: 18px;
            border-radius: 8px;
            background: #f5f2e9;
            color: #78684d;
            font-size: 13px;
            line-height: 1.8;
        }

        .button {
            display: block;
            margin-top: 25px;
            padding: 15px 20px;
            border-radius: 7px;
            background: #244b3e;
            color: white;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .button:hover {
            background: #17392d;
        }

        footer {
            border-top: 1px solid #e4e8df;
            padding: 25px 0;
            color: #788479;
            font-size: 12px;
        }

        @media (max-width: 700px) {
            .heading {
                flex-direction: column;
                align-items: start;
            }

            .cover {
                height: 290px;
            }

            .layout {
                grid-template-columns: 1fr;
            }

            .panel {
                padding: 22px;
            }

            .features {
                gap: 8px;
            }

            .feature strong {
                font-size: 17px;
            }

            .price {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <a class="logo" href="{{ route('home') }}">
                Immo<span>Space.</span>
            </a>

            <a class="back" href="{{ route('home') }}#biens">
                ← Nos biens
            </a>
        </header>

        <main>
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Accueil</a>
                /
                <a href="{{ route('home') }}#biens">Nos biens</a>
                /
                {{ $property->title }}
            </div>

            <div class="heading">
                <div>
                    <span class="badge">
                        {{ $property->transaction === 'Vente' ? 'À vendre' : 'À louer' }}
                    </span>

                    <h1>{{ $property->title }}</h1>

                    <p class="location">
                        {{ $property->city }}

                        @if ($property->district)
                            · {{ $property->district }}
                        @endif
                    </p>
                </div>

                <div class="price">
                    {{ number_format((float) $property->price, 0, ',', ' ') }} DH

                    @if ($property->transaction === 'Location')
                        <small>/ mois</small>
                    @endif
                </div>
            </div>

            <img
                class="cover"
                src="{{ $property->image ?: '/images/villa-marrakech.jpg' }}"
                alt="{{ $property->title }}"
            >

            <p class="photo-note">
                Annonce de démonstration · Photographie illustrative.
            </p>

            <div class="layout">
                <section class="panel">
                    <h2>Un aperçu du bien</h2>

                    <div class="features">
                        <div class="feature">
                            <strong>{{ $property->area }} m²</strong>
                            <span>Surface</span>
                        </div>

                        <div class="feature">
                            <strong>{{ $property->bedrooms }}</strong>
                            <span>Chambres</span>
                        </div>

                        <div class="feature">
                            <strong>{{ $property->type }}</strong>
                            <span>Type de bien</span>
                        </div>
                    </div>

                    <h2>Description</h2>

                    <p class="description">{{ $property->description ?: 'La description détaillée de ce bien sera ajoutée prochainement.' }}</p>
                </section>

                <aside class="panel">
                    <h2>Informations du bien</h2>

                    <dl class="details">
                        <div class="detail">
                            <dt>Référence</dt>
                            <dd>IMM-{{ str_pad((string) $property->id, 4, '0', STR_PAD_LEFT) }}</dd>
                        </div>

                        <div class="detail">
                            <dt>Ville</dt>
                            <dd>{{ $property->city }}</dd>
                        </div>

                        @if ($property->district)
                            <div class="detail">
                                <dt>Quartier</dt>
                                <dd>{{ $property->district }}</dd>
                            </div>
                        @endif

                        <div class="detail">
                            <dt>Transaction</dt>
                            <dd>{{ $property->transaction }}</dd>
                        </div>

                        <div class="detail">
                            <dt>Disponibilité</dt>
                            <dd>{{ $property->status }}</dd>
                        </div>
                    </dl>

                    
            <a
                data-visit-button
                class="button"
                href="{{ route('visits.create', $property) }}"
            >
                Demander une visite →
            </a>

            <div class="notice">
        
                        Envoyez votre demande de visite. La date souhaitée sera à confirmer par l’agence.
                    </div>

                    <a class="button" href="{{ route('home') }}#biens">
                        Découvrir les autres biens
                    </a>
                </aside>
            </div>
        </main>

        <footer>
            © {{ date('Y') }} ImmoSpace · Projet réalisé par Inass Silbi
        </footer>
    </div>
</body>
</html>