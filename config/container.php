<?php
declare(strict_types=1);

use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\AnnulerReservationServiceInterface;
use App\Service\CreerReservationService;
use App\Service\CreerReservationServiceInterface;
use function DI\autowire;

return [
    SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
    ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),
    CreerReservationServiceInterface::class => autowire(CreerReservationService::class),
    AnnulerReservationServiceInterface::class => autowire(AnnulerReservationService::class),
];
