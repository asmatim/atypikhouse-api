<?php

namespace App\Validator;

use App\Repository\ReservationRepository;
use App\Repository\OfferCommentRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Psr\Log\LoggerInterface;


class CanPostCommentValidator extends ConstraintValidator
{
    /**
     * @var ReservationRepository
     */
    protected $reservationRepository;
    /**
     * @var OfferCommentRepository
     */
    protected $offerCommentRepository;

    public function __construct(ReservationRepository $reservationRepository, OfferCommentRepository $offerCommentRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->offerCommentRepository = $offerCommentRepository;
    }

    public function validate($entity, Constraint $constraint)
    {
        if (null === $entity) {
            return;
        }

        $comment = $this->offerCommentRepository->findOneBy(['id' => $entity->getId()]);
        // check whether comment already exists
        if ($comment != null) {
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
