<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Reservation;
use DateTimeImmutable;

final class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function lister(): array
    {
        return Reservation::all()->all();
    }

    public function listerParSalle(int $salleId): array
    {
        return Reservation::where('salle_id', $salleId)->get()->all();
    }

    public function trouver(int $id): ?Reservation
    {
        return Reservation::find($id);
    }

    public function rechercherConflit(int $salleId, DateTimeImmutable $debut, DateTimeImmutable $fin): ?Reservation
    {
        return Reservation::where('salle_id', $salleId)
            ->where('statut', 'confirmee')
            ->where('date_debut', '<', $fin)
            ->where('date_fin', '>', $debut)
            ->first();
    }

    public function enregistrer(Reservation $reservation): Reservation
    {
        $reservation->save();
        return $reservation;
    }

    public function annuler(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulee';
        $reservation->save();
        return $reservation;
    }
}
