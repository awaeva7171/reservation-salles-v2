<?php
declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

final class SalleValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $regles = [
            'nom' => v::stringType()->length(2, 100),
            'batiment' => v::stringType()->length(2, 100),
            'capacite' => v::intVal()->between(1, 1000),
            'type' => v::in(['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion']),
            'active' => v::boolVal(),
        ];

        foreach ($regles as $champ => $regle) {
            try {
                $regle->assert($data[$champ] ?? null);
            } catch (NestedValidationException $e) {
                $errors[$champ] = $e->getMessages();
            }
        }

        return new ValidationResult(empty($errors), $errors, $data);
    }
}
