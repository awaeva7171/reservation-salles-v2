<?php
declare(strict_types=1);

session_start();

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/database.php';

use App\Controller\SalleController;
use App\Controller\ReservationController;
use App\Repository\EloquentSalleRepository;
use App\Repository\EloquentReservationRepository;
use App\Service\CreerReservationService;
use App\Service\AnnulerReservationService;
use App\Validation\SalleValidator;
use App\Validation\ReservationValidator;

$salleRepo = new EloquentSalleRepository();
$reservationRepo = new EloquentReservationRepository();

$salleController = new SalleController($salleRepo, new SalleValidator());
$reservationController = new ReservationController(
    $reservationRepo,
    $salleRepo,
    new CreerReservationService($salleRepo, $reservationRepo),
    new AnnulerReservationService($reservationRepo),
    new ReservationValidator()
);

$uri = strtok($_SERVER['REQUEST_URI'], '?');
$methode = $_SERVER['REQUEST_METHOD'];

if ($uri === '/salles' && $methode === 'GET') {
    $salleController->index();
} elseif ($uri === '/salles' && $methode === 'POST') {
    $salleController->store();
} elseif ($uri === '/salles/create' && $methode === 'GET') {
    $salleController->create();
} elseif (preg_match('#^/salles/(\d+)$#', $uri, $m) && $methode === 'GET') {
    $salleController->show((int) $m[1]);
} elseif (preg_match('#^/salles/(\d+)/edit$#', $uri, $m) && $methode === 'GET') {
    $salleController->edit((int) $m[1]);
} elseif (preg_match('#^/salles/(\d+)/edit$#', $uri, $m) && $methode === 'POST') {
    $salleController->update((int) $m[1]);
} elseif ($uri === '/reservations' && $methode === 'GET') {
    $reservationController->index();
} elseif ($uri === '/reservations' && $methode === 'POST') {
    $reservationController->store();
} elseif ($uri === '/reservations/create' && $methode === 'GET') {
    $reservationController->create();
} elseif (preg_match('#^/reservations/(\d+)$#', $uri, $m) && $methode === 'GET') {
    $reservationController->show((int) $m[1]);
} elseif (preg_match('#^/reservations/(\d+)/cancel$#', $uri, $m) && $methode === 'POST') {
    $reservationController->cancel((int) $m[1]);
} else {
    http_response_code(404);
    echo "Page non geree par ce test temporaire.";
}
