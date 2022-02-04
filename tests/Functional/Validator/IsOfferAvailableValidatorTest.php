<?php

namespace App\Tests\Functional\Validator;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Offer;
use App\Entity\User;
use App\Enum\ReservationStatus;
use App\Factory\ApiClientFactory;
use App\Factory\CityFactory;
use App\Factory\CountryFactory;
use App\Factory\OfferFactory;
use App\Factory\OfferTypeFactory;
use App\Factory\RegionFactory;
use App\Factory\ReservationFactory;
use App\Factory\UserFactory;
use App\Tests\TestUtil;
use DateTime;
use DateTimeZone;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class IsOfferAvailableValidatorTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    private string $offerReservationsURI = "/api/reservations";

    public function testUnvailableOfferReservation(): void
    {
        $this->createData();

        $offerIRI = $this->findIriBy(Offer::class, ["title" => "Offre"]);
        $clientIRI = $this->findIriBy(User::class, ["email" => "user.test@domain.com"]);

        $reservation2StartDate = '2022-06-05';
        $reservation2EndDate = '2022-06-09';

        $client = TestUtil::createClientWithCredentials();

        $client->request('POST', $this->offerReservationsURI, [
            'json' =>
            [
                "offer" => $offerIRI, "startDate" => $reservation2StartDate, "endDate" => $reservation2EndDate, "unitPrice" => 80, "client" => $clientIRI, "totalPrice" => 640,
            ],
        ]);

        $this->assertJsonContains(["hydra:description" => "L'offre Offre est déjà réservée."]);
        //$this->assertJsonContains(["violations" => [["message" => "L'offre Offre est déjà réservée.", "code" => null]]]);
    }

    private function createData()
    {
        CountryFactory::createOne(['name' => 'France']);
        RegionFactory::createOne(['name' => 'Oise', 'country' => CountryFactory::random()]);
        CityFactory::createOne(['name' => 'La Neuville-en-Hez', 'region' => RegionFactory::random()]);

        // create Offer Owner
        UserFactory::createOne(["roles" => ["ROLE_OWNER"]]);
        // create Offer
        OfferTypeFactory::createOne(['name' => 'Cabanes']);
        $offer = OfferFactory::createOne(["owner" => UserFactory::random(), "title" => "Offre"]);

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
                "client" => $clientUserForReservation, "offer" => $offer, "startDate" => $reservation1StartDate, "endDate" => $reservation1EndDate, "status" => ReservationStatus::CONFIRMED()
            ]
        );

        // create user for the second reservation
        UserFactory::createOne(["email" => "user.test@domain.com", "roles" => ["ROLE_USER"]]);
    }

    // method should run before each test
    protected function setUp(): void
    {
        parent::setUp();
        ApiClientFactory::createOne(["appId" => "nextjs", "appSecret" => "jRGxlaNOSyZpvK5fExpErAhXrQR/2jYp0gaznR/v2+I="]);
    }
}
