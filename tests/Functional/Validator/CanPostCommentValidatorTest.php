<?php

namespace App\Tests\Functional\Validator;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Offer;
use App\Entity\User;
use App\Factory\CityFactory;
use App\Factory\CountryFactory;
use App\Factory\OfferFactory;
use App\Factory\OfferTypeFactory;
use App\Factory\RegionFactory;
use App\Factory\ReservationFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CanPostCommentValidatorTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    private string $offerCommentsURI = "/api/offer_comments";

    public function testUserCanCommentOffer(): void
    {
        $this->createData();

        $offer1IRI = $this->findIriBy(Offer::class, ["title" => "Offre1"]);
        $clientIRI = $this->findIriBy(User::class, ["email" => "test.res@domain.com"]);

        $client = static::createClient();

        $client->request('POST', $this->offerCommentsURI, [
            'json' =>
            [
                "content" => "lorem ipsum dolem simit",
                "offer" => $offer1IRI,
                "client" => $clientIRI,
            ],
        ]);

        // User had already a reservation with this offer ==> can comment the offer
        $this->assertResponseIsSuccessful();
    }

    public function testUserCannotCommentOffer(): void
    {
        $this->createData();

        $offer2IRI = $this->findIriBy(Offer::class, ["title" => "Offre2"]);
        $clientIRI = $this->findIriBy(User::class, ["email" => "test.res@domain.com"]);

        $client = static::createClient();

        $client->request('POST', $this->offerCommentsURI, [
            'json' =>
            [
                "content" => "lorem ipsum dolem simit",
                "offer" => $offer2IRI,
                "client" => $clientIRI,
            ],
        ]);

        // User had never booked this offer ==> cannot comment the offer
        $this->assertResponseStatusCodeSame(422);
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
        $offer1 = OfferFactory::createOne(["owner" => UserFactory::random(), "title" => "Offre1"]);
        // create Offer 2
        OfferFactory::createOne(["owner" => UserFactory::random(), "title" => "Offre2"]);

        // create Reservation User
        $clientUserForReservation = UserFactory::createOne(["roles" => ["ROLE_USER"], "email" => "test.res@domain.com"]);

        ReservationFactory::createOne(
            [
                "client" => $clientUserForReservation, "offer" => $offer1
            ]
        );
    }
}
