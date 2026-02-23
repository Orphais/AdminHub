# AdminHub

Backoffice Symfony pour la gestion des utilisateurs, produits et clients.

## Démonstration

<video src="PRÉSENTATION - SYMFONY.mp4" controls width="100%"></video>

## Prérequis

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Symfony CLI (optionnel)

## Installation

```bash
# Cloner le dépôt
git clone <url-du-repo>
cd AdminHub

# Installer les dépendances
composer install

# Configurer la base de données
cp .env .env.local
# Modifier DATABASE_URL dans .env.local

# Créer la base de données et appliquer les migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Charger les fixtures
php bin/console doctrine:fixtures:load

# Lancer le serveur
symfony server start
# ou
symfony serve
# ou
php -S localhost:8000 -t public/
```

## Fonctionnalités

### Authentification

- Inscription et connexion sécurisées
- Trois niveaux de rôles : `ROLE_USER`, `ROLE_MANAGER`, `ROLE_ADMIN`

### Gestion des utilisateurs (admin uniquement)

- Liste, ajout, édition et suppression des utilisateurs
- Contrôle d'accès via Voter (`UserVoter`)

### Gestion des produits

- Liste publique avec tri par prix décroissant
- Formulaire de création multi-étapes (type → détails → logistique/licence → confirmation)
- Étapes conditionnelles selon le type : physique (logistique) ou digital (licence)
- Import CSV via commande CLI
- Export CSV

### Gestion des clients (admin et manager)

- Liste, ajout et édition des clients
- Contrôle d'accès via Voter (`CustomerVoter`)
- Validations : format email, caractères autorisés pour le nom, unicité de l'email
- Création via commande CLI interactive

## Commandes CLI

```bash
# Importer des produits depuis un fichier CSV (dans public/)
php bin/console app:import-products [filename.csv]

# Créer un client interactivement
php bin/console app:create-customer
```
