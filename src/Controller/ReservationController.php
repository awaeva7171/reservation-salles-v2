<?php
declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Exception\ReservationIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Repository\ReservationRepositoryInterface;
use App\Service\AnnulerReservationServiceInterface;
use App\Service\CreerReservationServiceInterface;
use App\Validation\ReservationValidator;
use DateTimeImmutable;

final class ReservationController extends AbstractController
{
    public function __construct(
        private ReservationRepositoryInterface $reservations,
        private ReservationValidator $validator,
        private CreerReservationServiceInterface $creerService,
        private AnnulerReservationServiceInterface $annulerService,
    ) {
    }

    public function index(): void
    {
        $salleId = $_GET['salle_id'] ?? null;
        $reservations = $salleId
            ? $this->reservations->listerParSalle((int) $salleId)
            : $this->reservations->lister();

        $this->renderView('reservation/index', ['reservations' => $reservations]);
    }

    public function show(int $id): void
    {
        $reservation = $this->reservations->trouver($id);
        $this->renderView('reservation/show', ['reservation' => $reservation]);
    }

    public function create(): void
    {
        $this->renderView('reservation/form', ['errors' => [], 'old' => []]);
    }

    public function store(): void
    {
        $resultat = $this->validator->validate($_POST);

        if (!$resultat->isValid()) {
            $this->renderView('reservation/form', ['errors' => $resultat->errors(), 'old' => $_POST]);
            return;
        }

        $data = $resultat->data();
        $dto = new CreerReservationDTO(
            salleId: (int) $data['salle_id'],
            responsable: $data['responsable'],
            email: $data['email'],
            motif: $data['motif'],
            dateDebut: new DateTimeImmutable($data['date_debut']),
            dateFin: new DateTimeImmutable($data['date_fin']),
        );

        try {
            $reservation = $this->creerService->creer($dto);
        } catch (SalleIndisponibleException $e) {
            $this->renderView('reservation/form', ['errors' => ['global' => [$e->getMessage()]], 'old' => $_POST]);
            return;
        }

        $this->redirect('/reservations/' . $reservation->id);
    }

    public function cancel(int $id): void
    {
        try {
            $this->annulerService->annuler($id);
        } catch (ReservationIntrouvableException $e) {
            http_response_code(404);
            $this->renderView('error/404');
            return;
        }

        $this->redirect('/reservations');
    }
}
