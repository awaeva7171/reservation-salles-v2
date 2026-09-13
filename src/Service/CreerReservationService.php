<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use DateTimeImmutable;

final class CreerReservationService implements CreerReservationServiceInterface
{
    public function __construct(
        private SalleRepositoryInterface $salles,
        private ReservationRepositoryInterface $reservations,
    ) {
    }

    public function creer(CreerReservationDTO $dto): Reservation
    {
        $salle = $this->salles->trouver($dto->salleId);

        if ($salle === null) {
            throw new SalleIndisponibleException("La salle n'existe pas.");
        }

        if (!$salle->active) {
            throw new SalleIndisponibleException("Cette salle ne peut pas etre reservee.");
        }

        if ($dto->dateDebut >= $dto->dateFin) {
            throw new SalleIndisponibleException("La date de debut doit preceder la date de fin.");
        }

        $dureeEnHeures = ($dto->dateFin->getTimestamp() - $dto->dateDebut->getTimestamp()) / 3600;
        if ($dureeEnHeures > 4) {
            throw new SalleIndisponibleException("Une reservation ne peut pas depasser quatre heures.");
        }

        $maintenant = new DateTimeImmutable();
        if ($dto->dateDebut <= $maintenant) {
            throw new SalleIndisponibleException("La reservation doit commencer dans le futur.");
        }

        $conflit = $this->reservations->rechercherConflit($dto->salleId, $dto->dateDebut, $dto->dateFin);
        if ($conflit !== null) {
            throw new SalleIndisponibleException("La salle est indisponible pendant cette periode.");
        }

        $reservation = new Reservation([
            'salle_id' => $dto->salleId,
            'responsable' => $dto->responsable,
            'email' => $dto->email,
            'motif' => $dto->motif,
            'date_debut' => $dto->dateDebut,
            'date_fin' => $dto->dateFin,
            'statut' => 'confirmee',
        ]);

        return $this->reservations->enregistrer($reservation);
    }
}
