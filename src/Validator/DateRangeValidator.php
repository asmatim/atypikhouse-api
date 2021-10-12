<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateRangeValidator extends ConstraintValidator
{
    public function validate($entity, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\DateRange */

        $startDateField = 'get' . ucfirst($constraint->startDateField);
        $endDateField = 'get' . ucfirst($constraint->endDateField);

        if (null === $entity || null === $entity->$startDateField() || null === $entity->$endDateField()) {
            return;
        }


        if ($entity->$startDateField() <= $entity->$endDateField()) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ startDate }}', $entity->$startDateField()->format('Y-m-d H:i:s'))
            ->setParameter('{{ endDate }}', $entity->$endDateField()->format('Y-m-d H:i:s'))
            ->atPath($constraint->startDateField)
            ->addViolation();

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ startDate }}', $entity->$startDateField()->format('Y-m-d H:i:s'))
            ->setParameter('{{ endDate }}', $entity->$endDateField()->format('Y-m-d H:i:s'))
            ->atPath($constraint->endDateField)
            ->addViolation();
    }
}
