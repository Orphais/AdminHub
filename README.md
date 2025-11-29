# Symfony Boilerplate

Un template de base Symfony préconfiguré avec Bootstrap et Bootswatch pour démarrer rapidement vos projets web.

## Technologies

-   **Symfony 7.4** - Framework PHP moderne
-   **PHP 8.2+** - Version PHP requise
-   **Bootstrap 5.3.8** - Framework CSS responsive
-   **Bootswatch Lux** - Thème Bootstrap élégant
-   **Stimulus 3.2.2** - Framework JavaScript léger
-   **Turbo 7.3.0** - Navigation SPA rapide
-   **Doctrine ORM** - Gestion de base de données
-   **PostgreSQL 16** - Base de données par défaut
-   **Asset Mapper** - Gestion des assets sans build tools

## Installation

### Prérequis

-   PHP 8.2 ou supérieur
-   Composer
-   Docker & Docker Compose (optionnel)

### Étapes d'installation

1. **Cloner le projet**

```bash
git clone <votre-repo>
cd symfony_boilerplate
```

2. **Installer les dépendances**

```bash
composer install
```

3. **Configurer l'environnement**

```bash
cp .env .env.local
# Éditer .env.local avec vos paramètres
```

4. **Démarrer les services Docker** (optionnel)

```bash
docker compose up -d
```

5. **Créer la base de données**

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

6. **Démarrer le serveur de développement**

```bash
symfony server:start
# ou
php -S localhost:8000 -t public/
```

## Structure du projet

```
symfony_boilerplate/
├── assets/              # Assets frontend (JS, CSS)
│   ├── app.js          # Point d'entrée JavaScript
│   ├── controllers/    # Contrôleurs Stimulus
│   └── styles/         # Styles personnalisés
├── config/             # Configuration Symfony
├── public/             # Racine web
├── src/
│   ├── Controller/     # Contrôleurs
│   ├── Entity/         # Entités Doctrine
│   └── Repository/     # Repositories
├── templates/          # Templates Twig
│   ├── base.html.twig  # Template de base avec Bootstrap
│   ├── pages/          # Pages du site
│   └── _partials/      # Composants réutilisables
├── tests/              # Tests PHPUnit
└── migrations/         # Migrations de base de données
```

## Fonctionnalités incluses

### Frontend

-   Bootstrap 5.3.8 avec thème Bootswatch Lux
-   Bootstrap Icons
-   Stimulus.js pour l'interactivité
-   Turbo pour la navigation rapide
-   Asset Mapper (pas besoin de Webpack/Vite)

### Backend

-   Doctrine ORM configuré
-   Système de migrations
-   Messenger pour les files de messages
-   Mailer configuré
-   Security Bundle
-   Validation et Serialization

### Développement

-   Docker Compose avec PostgreSQL et Mailpit
-   Maker Bundle pour la génération de code
-   Debug Toolbar & Web Profiler
-   PHPUnit pour les tests

## Utilisation

### Créer un nouveau contrôleur

```bash
php bin/console make:controller NomController
```

### Créer une entité

```bash
php bin/console make:entity NomEntite
```

### Créer une migration

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

### Lancer les tests

```bash
php bin/phpunit
```

## Configuration Bootstrap/Bootswatch

Le thème Bootswatch Lux est chargé dans `templates/base.html.twig` :

```twig
<link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.8/dist/lux/bootstrap.min.css" rel="stylesheet">
```

Pour changer de thème, remplacez `lux` par un autre thème disponible sur [Bootswatch](https://bootswatch.com/) :

-   `cerulean`, `cosmo`, `cyborg`, `darkly`, `flatly`, `journal`, `litera`, `lumen`, `lux`, `materia`, `minty`, `morph`, `pulse`, `quartz`, `sandstone`, `simplex`, `sketchy`, `slate`, `solar`, `spacelab`, `superhero`, `united`, `vapor`, `yeti`, `zephyr`

## Services Docker

-   **PostgreSQL** : `localhost:5432`
-   **Mailpit UI** : `http://localhost:8025`
-   **Mailpit SMTP** : `localhost:1025`

## Variables d'environnement

Principales variables dans `.env` :

```env
APP_ENV=dev
APP_SECRET=your-secret-here
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app"
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0
MAILER_DSN=smtp://localhost:1025
```

## Commandes utiles

```bash
# Lister les routes
php bin/console debug:router

# Vider le cache
php bin/console cache:clear

# Lister les services
php bin/console debug:container

# Créer un utilisateur (si Security est configuré)
php bin/console make:user

# Importer les assets
php bin/console importmap:install
```

## Personnalisation

Ce boilerplate est conçu pour être un point de départ. N'hésitez pas à :

-   Modifier le thème Bootswatch
-   Ajouter vos propres styles dans `assets/styles/`
-   Créer de nouveaux contrôleurs Stimulus dans `assets/controllers/`
-   Adapter la structure selon vos besoins
