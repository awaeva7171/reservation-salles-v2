<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Salle;

interface SalleRepositoryInterface
{
    public function getAllSalle(): array;

    public function findSalle(int $id): ?Salle;

    public function enregistrer(Salle $salle): Salle;
}
