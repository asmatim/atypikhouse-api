<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CanPostComment extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = "Vous ne pouvez pas commenter l'offre {{ offer }} que vous n'avez jamais reservé.";

    /**
     * This Annotation will be used on Entity level
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
