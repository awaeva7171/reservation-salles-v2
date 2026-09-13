# Notes pour l'oral — Questions par étape

 (exactement ce que demande la contrainte de l'Étape 12).# Notes pour l'oral — Questions par étape

## Étape 1 (Composer)

**1. Quel est le rôle de Composer ?**

C'est le gestionnaire de dépendances de PHP. Il télécharge, installe et met à jour les bibliothèques externes dont un projet a besoin (comme FastRoute, Eloquent...), et gère l'autoloading des classes pour qu'on n'ait jamais à écrire de require manuel.

**2. Quelle différence existe entre require et require-dev ?**

require liste les dépendances nécessaires en production (ex: illuminate/database). require-dev liste les outils utiles seulement pendant le développement/les tests (ex: phpunit/phpunit), non installés si on fait composer install --no-dev.

**3. Pourquoi faut-il versionner composer.lock ?**

Il fige les numéros de version exacts de chaque dépendance installée (y compris les sous-dépendances). Sans lui, deux développeurs (ou un serveur de prod) pourraient installer des versions légèrement différentes des mêmes paquets, ce qui peut casser l'application de façon imprévisible. Le versionner garantit que tout le monde installe exactement le même code.

**4. Pourquoi ne versionne-t-on pas vendor/ ?**

Parce qu'il est entièrement régénérable à partir de composer.json et composer.lock (via composer install), et qu'il peut contenir des milliers de fichiers — l'ajouter à Git alourdirait inutilement le dépôt sans apporter d'information utile.

## Étape 2 — Configurer Eloquent

**1. Quel rôle joue Capsule\Manager ?**

C'est le point d'entrée qui permet d'utiliser Eloquent sans Laravel. Il configure la connexion à la base de données (driver, host, credentials) et "démarre" Eloquent (bootEloquent()), rendant les modèles utilisables comme dans un vrai projet Laravel.

**2. Pourquoi Eloquent peut-il fonctionner sans Laravel ?**

Parce qu'Eloquent est un composant indépendant du paquet illuminate/database, découplé du reste du framework Laravel. Capsule\Manager reproduit manuellement ce que Laravel ferait automatiquement au démarrage (charger la config, enregistrer la connexion), donc on peut l'utiliser dans n'importe quel projet PHP.

**3. Où doit se trouver le démarrage de l'ORM ?**

Dans un fichier de configuration unique et centralisé (config/database.php chez toi), appelé une seule fois au démarrage de l'application — jamais dans un contrôleur ou un modèle. C'est ce qui garantit une connexion unique et cohérente dans toute l'app.

**4. Quelle différence existe entre ORM et SQL écrit à la main ?**

Le SQL à la main te demande d'écrire toi-même chaque requête (SELECT * FROM salle WHERE...). L'ORM (Eloquent) te permet de manipuler des objets PHP (Salle::find(1), $salle->reservations) et génère le SQL pour toi — plus lisible, plus sûr contre les injections SQL, mais avec un peu moins de contrôle fin sur les requêtes.

## Étape 3 — Créer les modèles

**1. Quel type de relation Eloquent avez-vous utilisé ?**

hasMany sur Salle (une salle a plusieurs réservations) et belongsTo sur Reservation (une réservation appartient à une seule salle) — une relation un-à-plusieurs.

**2. Pourquoi déclarer $fillable ou $guarded ?**

Pour se protéger du "mass assignment" : sans ça, si on fait Salle::create($_POST), un utilisateur malveillant pourrait injecter des champs qu'il ne devrait pas contrôler (comme id ou created_at). $fillable liste explicitement les colonnes autorisées.

**3. Pourquoi convertir active en booléen ?**

En base, active est stocké comme 0/1 (type numérique MySQL). Sans cast, PHP le manipulerait comme un entier. Le convertir en booléen rend le code plus lisible (if ($salle->active) plutôt que if ($salle->active === 1)) et plus sûr sémantiquement.

**4. Pourquoi convertir les dates en objets ?**

Les dates stockées en base sont de simples chaînes de caractères. En les castant en datetime (objets Carbon), on peut faire des comparaisons fiables ($date1->lt($date2)), calculer des durées, formater facilement — indispensable pour la règle de chevauchement des réservations à l'Étape 8.

## Étape 4

**1. Quelle différence existe entre migration et seeder ?**

Une migration définit ou modifie la structure de la base (créer une table, ajouter une colonne). Un seeder insère des données dans une structure déjà existante — ici, les 5 salles de départ.

**2. Pourquoi les données initiales doivent-elles être reproductibles ?**

Pour que n'importe qui (toi plus tard, un correcteur, un autre développeur) puisse recréer un environnement de travail identique en relançant simplement le script, sans dépendre d'une base déjà préparée à la main.

**3. Comment empêcher les doublons ?**

En vérifiant l'existence d'une donnée avant de l'insérer — ici via firstOrCreate, qui recherche d'abord par un critère unique (nom) avant de créer.

## Étape 5

**1. Pourquoi séparer la validation syntaxique des règles métier ?**

La validation syntaxique vérifie la forme des données (un email a bien un @, une chaîne fait la bonne longueur), indépendamment du contexte. Les règles métier dépendent de l'état de l'application (la salle est-elle active ? y a-t-il un chevauchement avec une autre réservation ?), ce qui nécessite d'interroger la base de données. Séparer les deux garde chaque couche simple et responsable d'une seule chose : le validateur ne parle jamais à la base, le service ne revérifie jamais le format.

**2. Pourquoi créer une interface de validation ?**

Pour découpler le reste de l'application (contrôleurs, etc.) de l'implémentation concrète du validateur. Le code appelant ne connaît que le contrat validate(array $data): ValidationResult — si demain on change la bibliothèque de validation sous-jacente, seule l'implémentation change, pas le reste de l'application.

**3. Pourquoi le validateur ne doit-il pas enregistrer les données ?**
Parce que ce n'est pas sa responsabilité : son seul rôle est de dire "ces données sont valides ou non". Enregistrer relève de la couche Repository/Service. Mélanger les deux rendrait le validateur difficile à tester isolément et violerait le principe de responsabilité unique (un des principes SOLID que tu dois analyser à l'Étape 13).

**4. Comment retourner plusieurs erreurs en une seule fois ?**
En accumulant les erreurs dans un tableau au fur et à mesure qu'on valide chaque champ (comme dans le code : $errors[$champ] = $e->getMessages(); dans une boucle), plutôt que de s'arrêter à la première erreur trouvée — ça permet à l'utilisateur de corriger tous les problèmes de son formulaire en une seule soumission plutôt que de découvrir les erreurs une par une.

## Étape 6

**1. Quelle différence existe entre DTO et modèle Eloquent ?**
Le modèle Eloquent (Salle, Reservation) est lié à la base de données — il sait se sauvegarder, se relier à d'autres modèles, etc. Le DTO est un simple conteneur de données, sans aucune connaissance de la persistance — il ne fait que transporter des données validées entre les couches (contrôleur → service).

**2. Pourquoi le DTO ne doit-il pas appeler save() ?**
Parce que ce n'est pas sa responsabilité — il n'a même pas accès à la base de données. Sauvegarder est le rôle du Repository/Service. Le DTO reste une structure de données passive.

**3. À quel moment transforme-t-on les chaînes en dates ?**
Au moment de la construction du DTO (dans depuisTableau()), après que la validation syntaxique a confirmé que les chaînes de dates sont bien formées — pas avant (les données brutes de $_POST sont toujours des chaînes), pas après (le service a besoin d'objets DateTimeImmutable pour faire les comparaisons).

**4. Le DTO doit-il contenir la règle de chevauchement ?**
Non — la règle de chevauchement est une règle métier qui nécessite d'interroger la base de données (chercher les réservations existantes), ce qui n'est pas le rôle d'un DTO. Elle sera implémentée dans le Service, à l'Étape 8.


## Étape 7

**1. Eloquent constitue-t-il déjà un accès aux données ?**
Oui — Eloquent est en soi un ORM, donc un moyen d'accéder aux données. Techniquement, on pourrait appeler Salle::find($id) directement partout.

**2. Pourquoi ajouter un Repository au-dessus d'Eloquent ?**
Pour isoler la dépendance à Eloquent derrière une interface. Ça centralise les requêtes à un seul endroit (au lieu d'être éparpillées dans les contrôleurs), facilite les tests (on peut simuler un Repository sans base de données réelle, comme demandé à l'Étape 12), et permettrait de changer d'ORM sans toucher au reste de l'application.

**3. Cette abstraction est-elle toujours nécessaire ?**
Pas toujours — sur un très petit projet ou un prototype rapide, ça peut être une couche superflue. Mais dès que le projet grandit ou doit être testé rigoureusement, elle devient très utile.

**4. Quel avantage apporte-t-elle ?**
Le découplage : le Service ne dépend que d'une interface (ReservationRepositoryInterface), pas de l'implémentation Eloquent — ce qui permet de le tester avec un faux Repository en mémoire, sans MySQL (exactement ce que demande la contrainte de l'Étape 12).

## Étape 8

**1. Pourquoi ces règles ne sont-elles pas dans le contrôleur ?**
Pour respecter la séparation des responsabilités : le contrôleur ne doit gérer que la requête HTTP (lire les données, appeler le service, rediriger), pas la logique métier. Placer les règles dans un service les rend testables indépendamment de tout contexte web (voir Étape 12), et réutilisables si une autre interface (API, CLI) devait un jour créer des réservations.

**2. Pourquoi le service dépend-il d'une interface de Repository ?**
Pour rester découplé d'Eloquent — le service ne connaît que le contrat (SalleRepositoryInterface, ReservationRepositoryInterface), pas son implémentation concrète. Ça permet de le tester avec un faux Repository en mémoire, sans base de données réelle.

**3. Quelle exception doit être levée en cas de conflit ?**
SalleIndisponibleException — puisque le conflit rend la salle indisponible pour la période demandée.

**4. Comment tester le service sans MySQL ?**
En créant une implémentation "en mémoire" de SalleRepositoryInterface et ReservationRepositoryInterface (par exemple avec de simples tableaux PHP simulant les données), injectée dans le constructeur du service à la place des vraies implémentations Eloquent. C'est exactement ce que demande la contrainte de l'Étape 12 : "Les tests unitaires des services ne doivent pas nécessiter MySQL."

## Étape 10

**1. Pourquoi FastRoute ne construit-il pas lui-même le contrôleur ?**
Parce que FastRoute ne connaît pas les dépendances dont un contrôleur a besoin (Repository, Validator, Service) — ce n'est pas son rôle. C'est au conteneur d'injection (PHP-DI) de savoir comment construire un contrôleur complet.

**2. Quelle différence existe entre 404 et 405 ?**
404 signifie que l'URL demandée n'existe dans aucune route. 405 signifie que l'URL existe, mais pas avec la méthode HTTP utilisée.

**3. Pourquoi contraindre {id} avec \d+ ?**
Pour garantir que seul un nombre entier valide soit accepté comme identifiant, évitant qu'une chaîne quelconque matche la route par erreur.

**4. Quel composant doit interpréter le handler retourné ?**
La classe Router — c'est elle qui reçoit le tableau [Controller::class, 'methode'] renvoyé par FastRoute et sait comment l'exécuter via le conteneur.


## Étape 11

**1. Quelle différence existe entre injection et conteneur ?**
L'injection est le principe de fournir ses dépendances à une classe via son constructeur plutôt que de les créer elle-même. Le conteneur (PHP-DI) est l'outil qui automatise cette injection.

**2. Qu'est-ce que l'autowiring ?**
La capacité du conteneur à deviner automatiquement comment construire une classe en lisant les types de son constructeur, sans configuration explicite.

**3. Pourquoi les interfaces nécessitent-elles une définition ?**
Parce que PHP-DI ne peut pas deviner seul quelle implémentation concrète utiliser pour une interface — il faut le préciser (comme on l'a fait pour Repository et Service, et via #[Inject] pour les Validators ambigus).

**4. Pourquoi limiter $container->get() au point d'entrée ?**
Pour éviter l'anti-pattern Service Locator — chaque classe doit recevoir ses dépendances via son constructeur, sans interroger elle-même le conteneur.

**5. Quel anti-pattern apparaît si toutes les classes interrogent le conteneur ?**
Le Service Locator — rend le code plus difficile à tester et masque les vraies dépendances d'une classe.