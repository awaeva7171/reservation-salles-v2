<?php
declare(strict_types=1);

namespace App\DTO;

final class CreerSalleDTO
{
    public function __construct(
        public readonly string $nom,
        public readonly string $batiment,
        public readonly int $capacite,
        public readonly bool $active,
        public readonly ?string $type = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nom: $data['nom'],
            batiment: $data['batiment'],
            capacite: (int) $data['capacite'],
            active: (bool) $data['active'],
            type: $data['type_salle_id'] ?? null,
        );
    }
}
