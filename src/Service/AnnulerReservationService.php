<?php
declare(strict_types=1);

namespace App\Service;

use App\Exception\ReservationIntrouvableException;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;

final class AnnulerReservationService implements AnnulerReservationServiceInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservations,
    ) {
    }

    public function annuler(int $reservationId): Reservation
    {
        $reservation = $this->reservations->trouver($reservationId);

        if ($reservation === null) {
            throw new ReservationIntrouvableException("Cette reservation n'existe pas.");
        }

        return $this->reservations->annuler($reservation);
    }
}
