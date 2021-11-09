<?php

namespace App\Validator;

use App\Repository\ReservationRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CanPostCommentValidator extends ConstraintValidator
{
    /**
     * @var ReservationRepository
     */
    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function validate($entity, Constraint $constraint)
    {
        if (null === $entity) {
            return;
        }

        $reservations =  $this->reservationRepository->findByOfferAndClient($entity->getOffer(), $entity->getClient());

        if ($reservations != null && !empty($reservations)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ offer }}', $entity->getOffer()->getTitle())
            ->addViolation();
    }
}
