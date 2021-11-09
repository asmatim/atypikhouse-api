<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsOfferAvailable extends Constraint
{
    public $message = "L'offre {{ offer }} est déjà réservée.";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
