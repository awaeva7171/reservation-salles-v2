<?php

// uniquement pour verifier les tables on pouvait meme le suprimer apres
require 'vendor/autoload.php';
require 'config/database.php';

use App\Model\Salle;
use App\Model\Reservation;

$salle = new Salle([
    'nom' => 'Salle Test',
    'batiment' => 'A',
    'capacite' => 20,
    'type' => 'cours',
    'active' => true,
]);
$salle->save();

echo "Salle créée avec id : " . $salle->id . "\n";

$reservation = new Reservation([
    'salle_id' => $salle->id,
    'responsable' => 'Test',
    'email' => 'test@test.sn',
    'motif' => 'Vérification',
    'date_debut' => '2026-09-20 10:00:00',
    'date_fin' => '2026-09-20 12:00:00',
    'statut' => 'confirmee',
]);
$reservation->save();

echo "Réservation créée, statut : " . $reservation->statut . "\n";
echo "Nombre de réservations pour cette salle : " . $salle->reservations->count() . "\n";
echo "Salle liée à cette réservation : " . $reservation->salle->nom . "\n";

// Nettoyage
$reservation->delete();
$salle->delete();
echo "Nettoyage effectué.\n";

/*
php verifier-modeles.php
*/ 