<?php
declare(strict_types=1);

namespace App\Controller;

abstract class AbstractController
{
    protected function renderView(string $vue, array $donnees = []): void
    {
        extract($donnees);
        require __DIR__ . '/../../templates/' . $vue . '.php';
    }

    protected function redirect(string $chemin): void
    {
        header('Location: ' . $chemin);
        exit;
    }
}
