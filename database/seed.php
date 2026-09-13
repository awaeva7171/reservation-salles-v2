<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

use App\Model\Salle;

$salles = [
    ['nom' => 'Amphitheatre A', 'batiment' => 'Batiment principal', 'capacite' => 250, 'type' => 'amphitheatre', 'active' => true],
    ['nom' => 'Salle B12', 'batiment' => 'Batiment B', 'capacite' => 40, 'type' => 'cours', 'active' => true],
    ['nom' => 'Laboratoire Chimie', 'batiment' => 'Batiment C', 'capacite' => 24, 'type' => 'laboratoire', 'active' => true],
    ['nom' => 'Salle Informatique 1', 'batiment' => 'Batiment B', 'capacite' => 30, 'type' => 'informatique', 'active' => true],
    ['nom' => 'Salle de reunion', 'batiment' => 'Batiment principal', 'capacite' => 12, 'type' => 'reunion', 'active' => true],
];

foreach ($salles as $donnees) {
    Salle::firstOrCreate(
        ['nom' => $donnees['nom']],
        $donnees
    );
}

echo "Donnees initiales inserees (ou deja presentes).\n";

/*
pour Lancer le script :
php database/seed.php
*/

/*
pour Vérifier que ca fonction
docker exec -it reservation-salles-mysql mysql -u root -proot reservation_salles -e "SELECT * FROM salle;"
*/ 