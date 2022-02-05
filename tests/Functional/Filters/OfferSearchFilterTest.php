<?php

namespace App\Tests\Functional\Filters;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ApiClientFactory;
use App\Factory\CityFactory;
use App\Factory\CountryFactory;
use App\Factory\OfferFactory;
use App\Factory\OfferTypeFactory;
use App\Factory\RegionFactory;
use App\Factory\UserFactory;
use App\Tests\TestUtil;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class OfferSearchFilterTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function testOfferSearch(): void
    {
        $this->createData();

        $client = TestUtil::createClientWithCredentials();

        $offerSearchURL = "/api/offers?search=Cabane";
        $response = $client->request('GET', $offerSearchURL, [
            'headers' => [
                "Accept" => "Application/Json"
            ]
        ]);
        $results = $response->toArray();

        $this->assertResponseIsSuccessful();

        // check the results contains the two offers with the keyword "Cabane"
        $this->assertJsonContains([["title" => "Jolie Cabane à l'Oise"], ["title" => "Cabane à La Neuville-en-Hez"]]);
        $this->assertCount(2, $results, "The search results should include exaclty two results.");
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
        OfferFactory::createOne(["owner" => UserFactory::random(), "title" => "Cabane à La Neuville-en-Hez"]);
        // create Offer 2
        OfferFactory::createOne(["owner" => UserFactory::random(), "title" => "Jolie Cabane à l'Oise"]);

        // create Offer 3
        OfferFactory::createOne(["owner" => UserFactory::random(), "title" => "Jolie Logement atypique à l'Oise"]);
    }

    // method should run before each test
    protected function setUp(): void
    {
        parent::setUp();
        ApiClientFactory::createOne(["appId" => "nextjs", "appSecret" => "jRGxlaNOSyZpvK5fExpErAhXrQR/2jYp0gaznR/v2+I="]);
    }
}
