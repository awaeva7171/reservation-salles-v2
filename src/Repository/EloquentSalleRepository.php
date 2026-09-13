<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Salle;

final class EloquentSalleRepository implements SalleRepositoryInterface
{
    public function getAllSalle(): array
    {
        return Salle::all()->all();
    }

    public function findSalle(int $id): ?Salle
    {
        return Salle::find($id);
    }

    public function enregistrer(Salle $salle): Salle
    {
        $salle->save();
        return $salle;
    }
}
