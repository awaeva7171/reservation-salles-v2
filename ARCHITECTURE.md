cat > ARCHITECTURE.md << 'EOF'
# Choix architecturaux

## MVC
Le projet suit une architecture en couches inspiree de MVC : Model (Eloquent), Vue (templates/), Controleur (src/Controller/).

## Front Controller
public/index.php est l'unique point d'entree de l'application. Toutes les requetes HTTP y passent avant d'etre routees.

## Router
src/Router.php recoit la methode et l'URI, utilise FastRoute pour trouver le bon controleur et la bonne action, gere aussi les erreurs 404 et 405.

## Validator
Chaque entite (Salle, Reservation) a son propre validateur (SalleValidator, ReservationValidator) implementant ValidatorInterface. Ils verifient uniquement la syntaxe des donnees, pas les regles metier.

## DTO
CreerSalleDTO et CreerReservationDTO transportent des donnees typees et immuables entre les couches, construits via fromArray() ou via un Builder.

## ORM et Active Record
Eloquent (illuminate/database) fournit l'ORM. Les modeles Salle et Reservation utilisent le pattern Active Record : chaque instance sait se sauvegarder elle-meme.

## Repository
EloquentSalleRepository et EloquentReservationRepository isolent l'acces aux donnees derriere une interface, permettant de tester les services sans base de donnees reelle.

## Service
CreerReservationService et AnnulerReservationService contiennent les regles metier (verification de disponibilite, chevauchement de reservations), avec leurs propres interfaces.

## Injection par constructeur
Toutes les classes recoivent leurs dependances via leur constructeur, jamais via une recherche interne dans le conteneur.

## Conteneur d'injection
PHP-DI est configure dans config/container.php. Application construit son propre conteneur dans son constructeur, seul point d'entree autorise a l'utiliser directement.

## Autowiring
PHP-DI devine automatiquement comment construire les classes concretes sans ambiguite, evitant d'avoir a tout declarer manuellement.

## Inversion de controle
Les classes de haut niveau (Service) dependent d'abstractions (interfaces de Repository), pas d'implementations concretes.

## Principes SOLID
- Responsabilite unique : chaque classe a un seul role (Validator valide, Repository accede aux donnees, Service applique les regles metier)
- Ouvert/ferme : on peut ajouter un nouveau Repository sans modifier le Service qui l'utilise
- Substitution de Liskov : toute implementation d'une interface peut remplacer une autre sans casser le code appelant
- Segregation des interfaces : chaque interface est specifique a un besoin precis (SalleRepositoryInterface, ReservationRepositoryInterface separees)
- Inversion des dependances : les Services dependent d'interfaces, pas de classes concretes
EOF