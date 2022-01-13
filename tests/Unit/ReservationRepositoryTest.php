<?php

namespace App\Tests\Unit;

use App\Factory\CityFactory;
use App\Factory\CountryFactory;
use App\Factory\OfferFactory;
use App\Factory\OfferTypeFactory;
use App\Factory\RegionFactory;
use App\Factory\ReservationFactory;
use App\Factory\UserFactory;
use App\Repository\ReservationRepository;
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
        ReservationFactory::createOne(["client" => $clientUserWithReservation, "offer" => $offer, "totalPrice" => 1000]);

        // create Client user with no reservation
        $clientUserNoReservation = UserFactory::createOne(["roles" => ["ROLE_USER"]]);

        $results = $reservationRepository->findByOfferAndClient($offer->object(), $clientUserNoReservation->object());


        $this->assertEmpty($results, "Client should have not reservation for the offer");
    }

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
        ReservationFactory::createOne(["client" => $clientUserWithReservation, "offer" => $offer, "totalPrice" => 1000]);

        // create Client user with no reservation
        UserFactory::createOne(["roles" => ["ROLE_USER"]]);

        $results = $reservationRepository->findByOfferAndClient($offer->object(), $clientUserWithReservation->object());

        // assert results is not empty
        $this->assertNotEmpty($results, "Client should have a reservation for the offer");
        //
        $this->assertCount(1, $results, "The results counts should be one.");
    }
}
