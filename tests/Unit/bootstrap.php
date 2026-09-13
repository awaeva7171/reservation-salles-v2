<?php
declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../../vendor/autoload.php';

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => ':memory:',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
