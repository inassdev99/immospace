# 🏡 ImmoSpace

Plateforme web de gestion immobilière développée avec **Laravel, React et MySQL**.

ImmoSpace permet aux visiteurs de rechercher des biens à vendre ou à louer, de consulter leurs caractéristiques et de demander une visite. Un espace administrateur permet de gérer les annonces et de suivre les demandes des clients.

## 📸 Aperçu

![Page d’accueil ImmoSpace](docs/accueil.png)

> Placez une capture de la page d’accueil dans `docs/accueil.png`.

## ✨ Fonctionnalités

### Espace public

- Consultation des biens disponibles.
- Recherche par ville, type de bien et transaction.
- Filtrage par budget maximum.
- Affichage des photos et des caractéristiques des biens.
- Page détaillée pour chaque propriété.
- Ajout et retrait des favoris pendant la visite.
- Formulaire de demande de visite.
- Interface adaptée aux ordinateurs et aux téléphones.

### Espace administrateur

- Connexion et déconnexion.
- Accès réservé aux administrateurs.
- Tableau de bord avec statistiques.
- Ajout, modification et suppression des biens.
- Téléchargement d’une photo par bien.
- Gestion des statuts : disponible, vendu ou loué.
- Consultation des demandes de visite.
- Suivi des demandes : nouveau, en cours, traité ou annulé.
- Pagination des annonces et des demandes.

## 🛠️ Technologies

| Technologie | Utilisation |
|---|---|
| Laravel | Logique métier, routes et accès aux données |
| React | Interface de la page d’accueil |
| Blade | Pages de détails, formulaires et administration |
| MySQL | Stockage des données |
| Vite | Compilation et serveur de développement |
| Tailwind CSS et CSS | Mise en forme de l’interface |
| Eloquent ORM | Manipulation des données |
| Git | Gestion des versions |

## 📋 Prérequis

- PHP compatible avec la version de Laravel du projet.
- Composer.
- Node.js et npm.
- MySQL.
- Extensions PHP nécessaires à Laravel, notamment `mbstring`, `fileinfo` et `pdo_mysql`.

Les versions des dépendances sont définies dans `composer.json` et `package.json`.

## ⚙️ Installation

### 1. Récupérer le projet

Clonez le dépôt, puis ouvrez un terminal à la racine du projet.

### 2. Installer les dépendances

```bash
composer install
npm install
```

### 3. Créer le fichier de configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurer MySQL

Créez une base de données nommée `immospace`, puis adaptez les paramètres du fichier `.env` :

```env
APP_NAME=ImmoSpace
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=immospace
DB_USERNAME=root
DB_PASSWORD=
```

Les identifiants ci-dessus correspondent à une installation locale MySQL sans mot de passe. Adaptez-les à votre environnement.

### 5. Créer les tables

```bash
php artisan config:clear
php artisan migrate
```

### 6. Ajouter les données de démonstration

```bash
php artisan db:seed --class=PropertySeeder
```

Les annonces de démonstration utilisent des images placées dans `public/images` :

```text
villa-marrakech.jpg
appartement-marrakech.jpg
maison-casablanca.jpg
appartement-rabat.jpg
villa-targa.jpg
maison-rabat.jpg
```

### 7. Créer le compte administrateur

```bash
php artisan db:seed --class=AdminSeeder
```

L’adresse email et le mot de passe généré s’affichent dans le terminal.

**Conservez ces identifiants. Relancer ce seeder remplace le mot de passe administrateur.**

### 8. Rendre les photos téléchargées accessibles

```bash
php artisan storage:link
```

### 9. Démarrer l’application

Dans un premier terminal :

```bash
php artisan serve
```

Dans un deuxième terminal :

```bash
npm run dev
```

Ouvrez ensuite :

**http://127.0.0.1:8000**

## 🔗 Pages principales

| Adresse | Description |
|---|---|
| `/` | Accueil, recherche et catalogue |
| `/biens/{id}` | Détails d’un bien disponible |
| `/biens/{id}/visite` | Demande de visite |
| `/admin/login` | Connexion administrateur |
| `/admin` | Tableau de bord |
| `/admin/properties/create` | Ajout d’un bien |
| `/admin/visites` | Gestion des demandes de visite |

Remplacez `{id}` par l’identifiant d’un bien existant.

## 📁 Organisation du projet

```text
app/
├── Http/
│   └── Controllers/
│       ├── AdminController.php
│       └── VisitRequestController.php
└── Models/
    ├── Property.php
    ├── User.php
    └── VisitRequest.php

database/
├── migrations/
└── seeders/
    ├── AdminSeeder.php
    └── PropertySeeder.php

public/
└── images/

resources/
├── css/
│   └── app.css
├── js/
│   └── app.jsx
└── views/
    ├── welcome.blade.php
    ├── property.blade.php
    ├── admin.blade.php
    ├── admin-property-form.blade.php
    ├── visit-form.blade.php
    └── admin-visits.blade.php

routes/
└── web.php
```

## 🗄️ Données principales

| Table | Contenu |
|---|---|
| `users` | Comptes utilisateurs et indicateur administrateur |
| `properties` | Annonces, prix, caractéristiques, photos et disponibilité |
| `visit_requests` | Coordonnées des clients, dates souhaitées et suivi des demandes |

## 🔐 Protection des accès

- Mots de passe hachés.
- Vérification du rôle administrateur.
- Protection CSRF des formulaires.
- Validation des données côté serveur.
- Limitation des tentatives de connexion et des envois de demandes.
- Validation du format et de la taille des photos téléchargées.

## 📌 Limites actuelles

- Les favoris sont conservés uniquement pendant la visite.
- Les comptes clients ne sont pas encore intégrés.
- Un bien dispose d’une seule photo.
- Les demandes de visite sont enregistrées sans envoi automatique d’email.
- Une date souhaitée ne constitue pas un rendez-vous confirmé.
- Les annonces initiales sont fictives et leurs photos sont illustratives.

## 🚀 Améliorations prévues

- Inscription et connexion des clients.
- Favoris enregistrés en base de données.
- Galerie de photos pour chaque bien.
- Notifications par email.
- Calendrier de rendez-vous.
- Carte de localisation.
- Historique des demandes dans un espace client.

## 👩‍💻 Réalisation

**Inass Silbi**

Projet de portfolio consacré au développement d’une plateforme de gestion immobilière avec Laravel, React et MySQL.