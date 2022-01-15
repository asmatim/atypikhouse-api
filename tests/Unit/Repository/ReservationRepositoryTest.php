<?php

namespace App\Tests\Unit\Repository;

use App\Enum\ReservationStatus;
use App\Factory\CityFactory;
use App\Factory\CountryFactory;
use App\Factory\OfferFactory;
use App\Factory\OfferTypeFactory;
use App\Factory\RegionFactory;
use App\Factory\ReservationFactory;
use App\Factory\UserFactory;
use App\Repository\ReservationRepository;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ReservationRepositoryTest extends KernelTestCase
{
    use ResetDatabase, Factories;

    private function createData()
    {
        // create One country, region, city for tests
        CountryFactory::createOne(['name' => 'France']);
        RegionFactory::createOne(['name' => 'Oise', 'country' => CountryFactory::random()]);
        CityFactory::createOne(['name' => 'La Neuville-en-Hez', 'region' => RegionFactory::random()]);
    }

    /**
     * Test Reservation search with given Client and Offer
     * TestCase when no result exists
     */
    public function testFindByOfferAndClientWhenNoResult(): void
    {
        self::bootKernel();

        $reservationRepository = static::getContainer()->get(ReservationRepository::class);

        $this->createData();
        // create Offer Owner
        UserFactory::createOne(["roles" => ["ROLE_OWNER"]]);
        // create Offer
        OfferTypeFactory::createOne(['name' => 'Cabanes']);
        $offer = OfferFactory::createOne(["owner" => UserFactory::random()]);

        // create Client User
        $clientUserWithReservation = UserFactory::createOne(["roles" => ["ROLE_USER"]]);

        // create Reservation for the client user
        ReservationFactory::createOne(["client" => $clientUserWithReservation, "offer" => $offer]);

        // create Client user with no reservation
        $clientUserNoReservation = UserFactory::createOne(["roles" => ["ROLE_USER"]]);

        $results = $reservationRepository->findByOfferAndClient($offer->object(), $clientUserNoReservation->object());


        $this->assertEmpty($results, "Client should have not reservation for the offer");
    }

    /**
     * Test Reservation search with given Client and Offer
     * TestCase when result exists
     */
    public function testFindByOfferAndClientWhenResult(): void
    {
        self::bootKernel();

        $reservationRepository = static::getContainer()->get(ReservationRepository::class);

        $this->createData();
        // create Offer Owner
        UserFactory::createOne(["roles" => ["ROLE_OWNER"]]);
        // create Offer
        OfferTypeFactory::createOne(['name' => 'Cabanes']);
        $offer = OfferFactory::createOne(["owner" => UserFactory::random()]);

        // create Client User
        $clientUserWithReservation = UserFactory::createOne(["roles" => ["ROLE_USER"]]);

        // create Reservation for the client user
        ReservationFactory::createOne(["client" => $clientUserWithReservation, "offer" => $offer]);

        // create Client user with no reservation
        UserFactory::createOne(["roles" => ["ROLE_USER"]]);

        $results = $reservationRepository->findByOfferAndClient($offer->object(), $clientUserWithReservation->object());

        // assert results is not empty
        $this->assertNotEmpty($results, "Client should have a reservation for the offer");
        //
        $this->assertCount(1, $results, "The results counts should be one.");
    }

    /**
     * Test Reservation check if a reservation already exist on the same date range
     * TestCase when a reservation is in conflict with the given reservation
     */
    public function testFindCollindingReservationsWhenExists()
    {
        self::bootKernel();

        $reservationRepository = static::getContainer()->get(ReservationRepository::class);

        $this->createData();
        // create Offer Owner
        UserFactory::createOne(["roles" => ["ROLE_OWNER"]]);
        // create Offer
        OfferTypeFactory::createOne(['name' => 'Cabanes']);
        $offer = OfferFactory::createOne(["owner" => UserFactory::random()]);

        // create Client User for reservation
        $clientUserForReservation = UserFactory::createOne(["roles" => ["ROLE_USER"]]);

        $reservation1StartDate = new DateTime('2022-06-04', new DateTimeZone('UTC'));
        $reservation1StartDate->modify("+16 hours");

        $reservation1EndDate = new DateTime('2022-06-08', new DateTimeZone('UTC'));
        $reservation1EndDate->modify("+11 hours");

        // Book reservation 1 from 04 June 2022 to 08 June 2022
        // create Reservation for the first client user
        ReservationFactory::createOne(
            [
                "client" => $clientUserForReservation
                , "offer" => $offer
                , "startDate" => $reservation1StartDate
                , "endDate" => $reservation1EndDate
                , "status" => ReservationStatus::COMPLETED()
            ]
        );

        $reservation2StartDate = new DateTime('2022-06-01', new DateTimeZone('UTC'));
        $reservation2StartDate->modify("+16 hours");

        $reservation2EndDate = new DateTime('2022-06-05', new DateTimeZone('UTC'));
        $reservation2EndDate->modify("+11 hours");

        // Search if there are any reservation in conflict with given startDate endDate and offer
        $results = $reservationRepository->findCollindingReservations($reservation2StartDate, $reservation2EndDate, $offer->object());

        $this->assertNotEmpty($results, "A reservation should exist for the offer");
        $this->assertCount(1, $results, "The results counts should be one.");
    }

    /**
     * Test Reservation check if a reservation already exist on the same date range
     * TestCase when a reservation not in conflict with the given params
     */
    public function testFindCollindingReservationsWhenNoConflict()
    {
        self::bootKernel();

        $reservationRepository = static::getContainer()->get(ReservationRepository::class);

        $this->createData();
        // create Offer Owner
        UserFactory::createOne(["roles" => ["ROLE_OWNER"]]);
        // create Offer
        OfferTypeFactory::createOne(['name' => 'Cabanes']);
        $offer = OfferFactory::createOne(["owner" => UserFactory::random()]);

        // create Client User for reservation
        $clientUserForReservation = UserFactory::createOne(["roles" => ["ROLE_USER"]]);

        $reservation1StartDate = new DateTime('2022-06-04', new DateTimeZone('UTC'));
        $reservation1StartDate->modify("+16 hours");

        $reservation1EndDate = new DateTime('2022-06-08', new DateTimeZone('UTC'));
        $reservation1EndDate->modify("+11 hours");

        // Book reservation 1 from 04 June 2022 to 08 June 2022
        // create Reservation for the first client user
        ReservationFactory::createOne(
            [
                "client" => $clientUserForReservation
                , "offer" => $offer
                , "startDate" => $reservation1StartDate
                , "endDate" => $reservation1EndDate
                , "status" => ReservationStatus::COMPLETED()
            ]
        );

        $reservation2StartDate = new DateTime('2022-06-08', new DateTimeZone('UTC'));
        $reservation2StartDate->modify("+16 hours");

        $reservation2EndDate = new DateTime('2022-06-11', new DateTimeZone('UTC'));
        $reservation2EndDate->modify("+11 hours");

        // Search if there are any reservation in conflict with given startDate endDate and offer
        $results = $reservationRepository->findCollindingReservations($reservation2StartDate, $reservation2EndDate, $offer->object());

        $this->assertEmpty($results, "No reservation should be in conflict. Results should be empty!");

    }
}
