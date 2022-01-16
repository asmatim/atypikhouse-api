<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateRangeValidator extends ConstraintValidator
{
    public function validate($entity, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\DateRange */

        if (null === $entity) {
            return;
        }

        $startDateField = 'get' . ucfirst($constraint->startDateField);
        $endDateField = 'get' . ucfirst($constraint->endDateField);

        if (null != $entity->$startDateField() && null != $entity->$endDateField()) {
            if ($entity->$startDateField() <= $entity->$endDateField()) {
                return;
            }
        }

        $formattedStartDate = $entity->$startDateField() ? $entity->$startDateField()->format('Y-m-d H:i:s') : '';
        $formattedEndDate = $entity->$endDateField() ? $entity->$endDateField()->format('Y-m-d H:i:s') : '';

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ startDate }}', $formattedStartDate)
            ->setParameter('{{ endDate }}', $formattedEndDate)
            ->atPath($constraint->startDateField)
            ->addViolation();

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ startDate }}', $formattedStartDate)
            ->setParameter('{{ endDate }}',  $formattedEndDate)
            ->atPath($constraint->endDateField)
            ->addViolation();
    }
}
