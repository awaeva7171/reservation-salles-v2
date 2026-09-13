<?php
declare(strict_types=1);

namespace App;

use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;
use function FastRoute\simpleDispatcher;

final class Router
{
    public function __construct(
        private ContainerInterface $container,
    ) {
    }

    public function dispatch(string $methode, string $uri): void
    {
        $routes = require __DIR__ . '/../routes/web.php';
        $dispatcher = simpleDispatcher($routes);

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($methode, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                $this->afficherErreur('error/404');
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                http_response_code(405);
                header('Allow: ' . implode(', ', $allowedMethods));
                $this->afficherErreur('error/405');
                break;

            case Dispatcher::FOUND:
                [$class, $method] = $routeInfo[1];
                $vars = array_map(
                    fn($valeur) => is_numeric($valeur) ? (int) $valeur : $valeur,
                    $routeInfo[2]
                );

                $controller = $this->container->get($class);
                $controller->$method(...array_values($vars));
                break;
        }
    }

    private function afficherErreur(string $vue): void
    {
        require __DIR__ . '/../templates/' . $vue . '.php';
    }
}
