<?php
declare(strict_types=1);

namespace App;

final class Application
{
    public function run(): void
    {
        echo "Application démarrée";
    }
}


/*pour demarrer l'application:
php -r "require 'vendor/autoload.php'; (new App\Application())->run();"*/