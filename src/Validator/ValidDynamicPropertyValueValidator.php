<?php

namespace App\Validator;

use App\Enum\DynamicPropertyType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidDynamicPropertyValueValidator extends ConstraintValidator
{

    public function validate($entity, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\ValidDynamicPropertyValue */

        if (null === $entity || '' === $entity) {
            return;
        }

        $this->valueTypeShouldMatch($entity, $constraint);
        $this->mandatoryValueNotBlank($entity, $constraint);
    }

    private function valueTypeShouldMatch($entity, $constraint)
    {
        $dpType = $entity->getDynamicProperty()->getType();
        $dpValue = $entity->getValue();

        if (DynamicPropertyType::NUMERICAL() == $dpType) {
            if (!is_numeric($dpValue)) {
                $this->context->buildViolation($constraint->messageType)
                    ->setParameter('{{ dynamicProperty }}', $entity->getDynamicProperty()->getName())
                    ->setParameter('{{ type }}', $entity->getDynamicProperty()->getType())
                    ->atPath($constraint->targetField)
                    ->addViolation();
            }
        }

        if (DynamicPropertyType::BINARY() == $dpType) {
            if ($dpValue !== "true" && $dpValue !== "false") {
                $this->context->buildViolation($constraint->messageType)
                    ->setParameter('{{ dynamicProperty }}', $entity->getDynamicProperty()->getName())
                    ->setParameter('{{ type }}', $entity->getDynamicProperty()->getType())
                    ->atPath($constraint->targetField)
                    ->addViolation();
            }
        }

        if (DynamicPropertyType::TEXT() == $dpType) {
            if (!is_string($dpValue)) {
                $this->context->buildViolation($constraint->messageType)
                    ->setParameter('{{ dynamicProperty }}', $entity->getDynamicProperty()->getName())
                    ->setParameter('{{ type }}', $entity->getDynamicProperty()->getType())
                    ->atPath($constraint->targetField)
                    ->addViolation();
            }
        }
    }

    private function mandatoryValueNotBlank($entity, $constraint)
    {
        $isMandatory = $entity->getDynamicProperty()->getIsMandatory();
        $dpValue = $entity->getValue();

        if ($isMandatory && empty($dpValue)) {
            $this->context->buildViolation($constraint->messageMandatory)
                ->setParameter('{{ dynamicProperty }}', $entity->getDynamicProperty()->getName())
                ->atPath($constraint->targetField)
                ->addViolation();
        }
    }
}
