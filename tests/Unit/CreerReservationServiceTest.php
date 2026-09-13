<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Salle;
use App\Service\CreerReservationService;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class CreerReservationServiceTest extends TestCase
{
    private FakeSalleRepository $salles;
    private FakeReservationRepository $reservations;
    private CreerReservationService $service;

    protected function setUp(): void
    {
        $this->salles = new FakeSalleRepository();
        $this->reservations = new FakeReservationRepository();
        $this->service = new CreerReservationService($this->salles, $this->reservations);

        $salle = new Salle(['nom' => 'Salle Test', 'batiment' => 'A', 'capacite' => 20, 'type' => 'cours', 'active' => true]);
        $salle->id = 1;
        $this->salles->ajouter($salle);
    }

    private function dto(int $salleId, string $debut, string $fin): CreerReservationDTO
    {
        return new CreerReservationDTO(
            salleId: $salleId,
            responsable: 'Awa Ndiaye',
            email: 'awa@universite.sn',
            motif: 'Cours de test',
            dateDebut: new DateTimeImmutable($debut),
            dateFin: new DateTimeImmutable($fin),
        );
    }

    public function testReservationValide(): void
    {
        $id = $this->service->creatReservation($this->dto(1, '+1 day 10:00', '+1 day 12:00'));
        $this->assertIsInt($id);
    }

    public function testSalleInexistante(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creatReservation($this->dto(999, '+1 day 10:00', '+1 day 12:00'));
    }

    public function testSalleInactive(): void
    {
        $salleInactive = new Salle(['nom' => 'Salle Inactive', 'batiment' => 'B', 'capacite' => 10, 'type' => 'reunion', 'active' => false]);
        $salleInactive->id = 2;
        $this->salles->ajouter($salleInactive);

        $this->expectException(SalleIndisponibleException::class);
        $this->service->creatReservation($this->dto(2, '+1 day 10:00', '+1 day 12:00'));
    }

    public function testDateFinAnterieureAuDebut(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creatReservation($this->dto(1, '+1 day 12:00', '+1 day 10:00'));
    }

    public function testDureeSuperieureAQuatreHeures(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creatReservation($this->dto(1, '+1 day 08:00', '+1 day 13:00'));
    }

    public function testDatePassee(): void
    {
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creatReservation($this->dto(1, '-1 day 10:00', '-1 day 12:00'));
    }

    public function testConflitAvecUneReservation(): void
    {
        $this->service->creatReservation($this->dto(1, '+1 day 10:00', '+1 day 12:00'));

        $this->expectException(SalleIndisponibleException::class);
        $this->service->creatReservation($this->dto(1, '+1 day 11:00', '+1 day 13:00'));
    }

    public function testReservationVoisineSansChevauchement(): void
    {
        $this->service->creatReservation($this->dto(1, '+1 day 10:00', '+1 day 12:00'));

        $id = $this->service->creatReservation($this->dto(1, '+1 day 12:00', '+1 day 14:00'));
        $this->assertIsInt($id);
    }
}
