<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\SalleRepositoryInterface;
use App\Validation\SalleValidator;
use App\Model\Salle;

final class SalleController extends AbstractController
{
    public function __construct(
        private SalleRepositoryInterface $salles,
        private SalleValidator $validator,
    ) {
    }

    public function index(): void
    {
        $salles = $this->salles->lister();
        $this->renderView('salle/index', ['salles' => $salles]);
    }

    public function show(int $id): void
    {
        $salle = $this->salles->trouver($id);
        $this->renderView('salle/show', ['salle' => $salle]);
    }

    public function create(): void
    {
        $this->renderView('salle/form', ['errors' => [], 'old' => [], 'salle' => null]);
    }

    public function store(): void
    {
        $resultat = $this->validator->validate($_POST);

        if (!$resultat->isValid()) {
            $this->renderView('salle/form', ['errors' => $resultat->errors(), 'old' => $_POST, 'salle' => null]);
            return;
        }

        $salle = new Salle($resultat->data());
        $this->salles->enregistrer($salle);

        $this->redirect('/salles');
    }

    public function edit(int $id): void
    {
        $salle = $this->salles->trouver($id);
        $this->renderView('salle/form', ['errors' => [], 'old' => [], 'salle' => $salle]);
    }

    public function update(int $id): void
    {
        $resultat = $this->validator->validate($_POST);
        $salle = $this->salles->trouver($id);

        if (!$resultat->isValid()) {
            $this->renderView('salle/form', ['errors' => $resultat->errors(), 'old' => $_POST, 'salle' => $salle]);
            return;
        }

        $salle->fill($resultat->data());
        $this->salles->enregistrer($salle);

        $this->redirect('/salles/' . $id);
    }
}
