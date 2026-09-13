# Changelog

## [0.13.0] - Finalisation
### Ajoute
- README complet, ARCHITECTURE.md, diagramme de classes

## [0.12.0] - Tests
### Ajoute
- Tests unitaires du service de creation de reservation (8 scenarios)
- Configuration PHPUnit avec SQLite en memoire

## [0.11.0] - Conteneur d'injection
### Ajoute
- Configuration PHP-DI
- Application autonome qui construit son propre conteneur

## [0.10.0] - Routeur
### Ajoute
- Configuration FastRoute
- Classe Router separee d'Application

## [0.9.0] - Interface web
### Ajoute
- Controleurs Salle et Reservation
- Vues avec navigation complete et mise en forme CSS
- AbstractController avec renderView et redirect

## [0.8.0] - Regles metier
### Ajoute
- Services de creation et annulation de reservation, avec interfaces
- Exceptions metier

## [0.7.0] - Acces aux donnees
### Ajoute
- Repositories Salle et Reservation avec interfaces

## [0.6.0] - Objets de transport
### Ajoute
- DTO et Builders pour Salle et Reservation

## [0.5.0] - Validation
### Ajoute
- Validation des salles et reservations

## [0.4.0] - Donnees initiales
### Ajoute
- Script de creation des 5 salles de depart

## [0.3.0] - Modeles
### Ajoute
- Modeles Eloquent Salle et Reservation

## [0.2.0] - Base de donnees
### Ajoute
- Configuration Eloquent avec MySQL dockerise
- Script de migration PHP

## [0.1.0] - Initialisation Composer
### Ajoute
- Autoloading PSR-4, dependances installees

## [0.0.0] - Initialisation du depot
### Ajoute
- Depot Git initialise