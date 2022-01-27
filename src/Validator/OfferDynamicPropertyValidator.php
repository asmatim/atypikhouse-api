<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class OfferDynamicPropertyValidator extends ConstraintValidator
{
    // $entity contains Offer
    public function validate($entity, Constraint $constraint)
    {
        if ($entity === null || empty($entity)) {
            return;
        }

        $this->offerContainsOnlyCompatibleDynamicProps($entity, $constraint);
        $this->offerContainsAllMandatoryDynamicProps($entity, $constraint);
    }

    private function offerContainsOnlyCompatibleDynamicProps($entity, Constraint $constraint)
    {
        $offer_offerType = $entity->getOfferType();
        if ($offer_offerType == null) {
            // nothing to validate offerType not available
            return;
        }

        $dp_values = $entity->getDynamicPropertyValues();

        $offer_dynamicProperties = array();

        foreach ($dp_values as $dp_value) {
            $offer_dynamicProperties[] = $dp_value->getDynamicProperty();
        }

        if (!empty($offer_dynamicProperties)) {
            foreach ($offer_dynamicProperties as $offer_dynamicProperty) {
                if ($offer_dynamicProperty->getOfferType() != $offer_offerType) {

                    $this->context->buildViolation($constraint->messageCompatible)
                        ->setParameter('{{ dynamicProperty }}', $offer_dynamicProperty->getName())
                        ->setParameter('{{ offerType }}', $offer_offerType->getName())
                        ->atPath($constraint->targetField)
                        ->addViolation();
                }
            }
        }
    }

    private function offerContainsAllMandatoryDynamicProps($entity, Constraint $constraint)
    {
        $offer_offerType = $entity->getOfferType();
        if ($offer_offerType == null) {
            // nothing to validate offerType not available
            return;
        }

        $offerType_dProperties = $offer_offerType->getDynamicProperties();

        $dp_values = $entity->getDynamicPropertyValues();

        $offer_dynamicProperties = array();

        foreach ($dp_values as $dp_value) {
            $offer_dynamicProperties[] = $dp_value->getDynamicProperty();
        }

        $dpExist = false;
        foreach ($offerType_dProperties as $offerType_dProperty) {
            if ($offerType_dProperty->getIsMandatory()) {
                $dpExist = false;
                foreach ($offer_dynamicProperties as $offer_dynamicProperty) {
                    if ($offer_dynamicProperty->getId() === $offerType_dProperty->getId()) {
                        $dpExist = true;
                        break;
                    }
                }
                if (!$dpExist) {
                    $this->context->buildViolation($constraint->messageMandatory)
                        ->setParameter('{{ dynamicProperty }}', $offerType_dProperty->getName())
                        ->setParameter('{{ offerType }}', $offer_offerType->getName())
                        ->atPath($constraint->targetField)
                        ->addViolation();
                }
            }
        }
    }
}
