<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateRange extends Constraint
{
    /*
     * Error message of the custom validation @DateRange
     */
    public $message = 'The startDate "{{ startDate }}" should be before the endDate "{{ endDate }}".';
    public $startDateField = "startDate";
    public $endDateField = "endDate";
    
    /**
     * This Annotation will be used on Entity level
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
