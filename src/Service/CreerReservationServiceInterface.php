<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;

interface CreerReservationServiceInterface
{
    public function creatReservation(CreerReservationDTO $dto): int;
}
