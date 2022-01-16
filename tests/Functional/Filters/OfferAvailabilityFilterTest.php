<?php

namespace App\Tests\Functional\Filters;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\CityFactory;
use App\Factory\CountryFactory;
use App\Factory\OfferFactory;
use App\Factory\OfferTypeFactory;
use App\Factory\RegionFactory;
use App\Factory\ReservationFactory;
use App\Factory\UserFactory;
use DateTime;
use DateTimeZone;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class OfferAvailabilityFilterTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function testOfferSearchAvailable(): void
    {
        $this->createData();

        $client = static::createClient();

        $offerSearchURL = "/api/offers?startDate=2022-07-01&endDate=2022-07-05";
        $response = $client->request('GET', $offerSearchURL, [
            'headers' => [
                "Accept" => "Application/Json"
            ]
        ]);
        $results = $response->toArray();

        $this->assertResponseIsSuccessful();

        // check the results contains the three offers all available
        $this->assertJsonContains([
            ["title" => "Cabane à La Neuville-en-Hez"], ["title" => "Jolie Cabane à l'Oise"], ["title" => "Jolie Logement atypique à l'Oise"]
        ]);
        $this->assertCount(3, $results, "The search results should include exaclty 3 results.");
    }

    public function testOfferSearchNotAvailable(): void
    {
        $this->createData();

        $client = static::createClient();

        $offerSearchURL = "/api/offers?startDate=2022-06-02&endDate=2022-06-09";
        $response = $client->request('GET', $offerSearchURL, [
            'headers' => [
                "Accept" => "Application/Json"
            ]
        ]);
        $results = $response->toArray();

        $this->assertResponseIsSuccessful();

        // check the results contains the 2 offers all available the 3rd one is reserverd already during the provided dates
        $this->assertJsonContains([
            ["title" => "Jolie Cabane à l'Oise"], ["title" => "Jolie Logement atypique à l'Oise"]
        ]);
        $this->assertCount(2, $results, "The search results should include exaclty 2 results.");
    }

    private function createData()
    {
        // create One country, region, city for tests
        CountryFactory::createOne(['name' => 'France']);
        RegionFactory::createOne(['name' => 'Oise', 'country' => CountryFactory::random()]);
        CityFactory::createOne(['name' => 'La Neuville-en-Hez', 'region' => RegionFactory::random()]);

        // create Offer Owner
        UserFactory::createOne(["roles" => ["ROLE_OWNER"]]);


        OfferTypeFactory::createOne(['name' => 'Cabanes']);
        // create Offer 1
        $offer1 = OfferFactory::createOne(["owner" => UserFactory::random(), "title" => "Cabane à La Neuville-en-Hez"]);
        // create Offer 2
        OfferFactory::createOne(["owner" => UserFactory::random(), "title" => "Jolie Cabane à l'Oise"]);
        // create Offer 3
        OfferFactory::createOne(["owner" => UserFactory::random(), "title" => "Jolie Logement atypique à l'Oise"]);

        // create Client User
        $clientUserWithReservation = UserFactory::createOne(["roles" => ["ROLE_USER"]]);

        // create Reservation for the offer1 from 2022-06-05 to 2022-06-12
        $reservationStartDate = new DateTime('2022-06-08', new DateTimeZone('UTC'));
        $reservationStartDate->modify("+16 hours");

        $reservationEndDate = new DateTime('2022-06-11', new DateTimeZone('UTC'));
        $reservationEndDate->modify("+11 hours");

        ReservationFactory::createOne(["client" => $clientUserWithReservation, "offer" => $offer1, "startDate" => $reservationStartDate, "endDate" => $reservationEndDate]);
    }
}
