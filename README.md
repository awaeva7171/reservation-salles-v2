# Gestion des reservations de salles universitaires

Application web permettant de consulter les salles et de gerer leurs reservations, developpee en PHP oriente objet, sans framework complet, avec des composants specialises (FastRoute, Eloquent, PHP-DI, Respect\Validation).

## Prerequis

- PHP 8.3
- Composer
- Docker et Docker Compose (pour MySQL)

## Installation

1. Cloner le depot :
   git clone https://github.com/awaeva7171/reservation-salles-v2.git
   cd reservation-salles-v2

2. Installer les dependances :
   composer install

3. Configurer l'environnement :
   cp .env.example .env

4. Demarrer MySQL avec Docker :
   docker compose up -d

5. Creer les tables :
   php database/migrations/migrate.php

6. Ajouter les donnees initiales :
   php database/seed.php

7. Lancer le serveur :
   php -S localhost:8000 -t public

8. Ouvrir http://localhost:8000/salles dans le navigateur.

## Executer les tests

./vendor/bin/phpunit

## Architecture

Voir ARCHITECTURE.md pour le detail des choix architecturaux.
