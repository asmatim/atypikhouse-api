<?php

namespace App\Tests\Unit\Validator;

use App\Entity\Reservation;
use App\Validator\DateRange;
use App\Validator\DateRangeValidator;
use DateTime;
use DateTimeZone;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class DateRangeValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new DateRangeValidator();
    }

    public function testDateRangeIsValid()
    {
        $reservation = new Reservation();
        $reservation->setStartDate(new DateTime('2022-04-06', new DateTimeZone('UTC')));
        $reservation->setEndDate(new DateTime('2022-04-16', new DateTimeZone('UTC')));

        $this->validator->validate($reservation, new DateRange());

        $this->assertNoViolation();
    }

    public function testDateRangeIsInvalid()
    {
        $reservation = new Reservation();
        $reservation->setStartDate(new DateTime('2022-04-26', new DateTimeZone('UTC')));
        $reservation->setEndDate(new DateTime('2022-04-25', new DateTimeZone('UTC')));
        $this->validator->validate($reservation, new DateRange());

        // StartDate Field is invalid
        $this->buildViolation((new DateRange())->message)
            ->setParameter('{{ startDate }}', $reservation->getStartDate()->format('Y-m-d H:i:s'))
            ->setParameter('{{ endDate }}', $reservation->getEndDate()->format('Y-m-d H:i:s'))
            ->atPath('property.path.startDate')
            // EndDate Field is invalid
            ->buildNextViolation((new DateRange())->message)
            ->setParameter('{{ startDate }}', $reservation->getStartDate()->format('Y-m-d H:i:s'))
            ->setParameter('{{ endDate }}', $reservation->getEndDate()->format('Y-m-d H:i:s'))
            ->atPath('property.path.endDate')
            ->assertRaised();
    }

    public function testDateRangeIsInvalidStartDateMissing()
    {
        $reservation = new Reservation();
        // Missing StartDate
        //$reservation->setStartDate(new DateTime('2022-04-26', new DateTimeZone('UTC')));
        $reservation->setEndDate(new DateTime('2022-04-25', new DateTimeZone('UTC')));
        $this->validator->validate($reservation, new DateRange());

        // StartDate Field is invalid
        $this->buildViolation((new DateRange())->message)
            ->setParameter('{{ startDate }}', '')
            ->setParameter('{{ endDate }}', $reservation->getEndDate()->format('Y-m-d H:i:s'))
            ->atPath('property.path.startDate')
            // EndDate Field is invalid
            ->buildNextViolation((new DateRange())->message)
            ->setParameter('{{ startDate }}', '')
            ->setParameter('{{ endDate }}', $reservation->getEndDate()->format('Y-m-d H:i:s'))
            ->atPath('property.path.endDate')
            ->assertRaised();
    }

    public function testDateRangeIsInvalidEndDateMissing()
    {
        $reservation = new Reservation();
        $reservation->setStartDate(new DateTime('2022-04-26', new DateTimeZone('UTC')));
        // Missing end Date
        //$reservation->setEndDate(new DateTime('2022-04-25', new DateTimeZone('UTC')));
        $this->validator->validate($reservation, new DateRange());

        // StartDate Field is invalid
        $this->buildViolation((new DateRange())->message)
            ->setParameter('{{ startDate }}', $reservation->getStartDate()->format('Y-m-d H:i:s'))
            ->setParameter('{{ endDate }}', '')
            ->atPath('property.path.startDate')
            // EndDate Field is invalid
            ->buildNextViolation((new DateRange())->message)
            ->setParameter('{{ startDate }}', $reservation->getStartDate()->format('Y-m-d H:i:s'))
            ->setParameter('{{ endDate }}', '')
            ->atPath('property.path.endDate')
            ->assertRaised();
    }
}
