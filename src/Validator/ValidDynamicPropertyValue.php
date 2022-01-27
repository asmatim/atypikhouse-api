<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidDynamicPropertyValue extends Constraint
{
    public $messageType = 'Le type de la propriété dynamique "{{ dynamicProperty }}" doit être {{ type }}.';
    public $messageMandatory = 'La valeur de la propriété dynamique "{{ dynamicProperty }}" est obligatoire.';

    public $targetField = 'value';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
