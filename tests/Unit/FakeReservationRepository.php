<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use DateTimeImmutable;

final class FakeReservationRepository implements ReservationRepositoryInterface
{
    private array $reservations = [];
    private int $prochainId = 1;

    public function getAllReservation(): array
    {
        return array_values($this->reservations);
    }

    public function listerParSalle(int $salleId): array
    {
        return array_values(array_filter(
            $this->reservations,
            fn(Reservation $r) => $r->salle_id === $salleId
        ));
    }

    public function findReservation(int $id): ?Reservation
    {
        return $this->reservations[$id] ?? null;
    }

    public function rechercherConflit(int $salleId, DateTimeImmutable $debut, DateTimeImmutable $fin): ?Reservation
    {
        foreach ($this->reservations as $reservation) {
            if ($reservation->salle_id !== $salleId) {
                continue;
            }
            if ($reservation->statut !== 'confirmee') {
                continue;
            }
            if ($debut < $reservation->date_fin && $fin > $reservation->date_debut) {
                return $reservation;
            }
        }
        return null;
    }

    public function enregistrer(Reservation $reservation): Reservation
    {
        if (!$reservation->id) {
            $reservation->id = $this->prochainId++;
        }
        $this->reservations[$reservation->id] = $reservation;
        return $reservation;
    }

    public function annuler(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulee';
        $this->reservations[$reservation->id] = $reservation;
        return $reservation;
    }
}
