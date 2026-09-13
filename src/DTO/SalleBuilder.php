<?php
declare(strict_types=1);

namespace App\DTO;

final class SalleBuilder
{
    private ?string $nom = null;
    private ?string $batiment = null;
    private ?int $capacite = null;
    private ?string $type = null;
    private ?bool $active = null;

    public function avecNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function avecBatiment(string $batiment): self
    {
        $this->batiment = $batiment;
        return $this;
    }

    public function avecCapacite(int $capacite): self
    {
        $this->capacite = $capacite;
        return $this;
    }

    public function avecType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function avecActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function construire(): CreerSalleDTO
    {
        return new CreerSalleDTO(
            nom: $this->nom,
            batiment: $this->batiment,
            capacite: $this->capacite,
            type: $this->type,
            active: $this->active,
        );
    }
}
