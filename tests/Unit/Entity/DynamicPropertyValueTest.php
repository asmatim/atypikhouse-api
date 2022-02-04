<?php

namespace App\Tests\Unit\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\City;
use App\Entity\DynamicProperty;
use App\Entity\OfferType;
use App\Entity\User;
use App\Enum\DynamicPropertyType;
use App\Factory\ApiClientFactory;
use App\Factory\CityFactory;
use App\Factory\CountryFactory;
use App\Factory\DynamicPropertyFactory;
use App\Factory\DynamicPropertyValueFactory;
use App\Factory\OfferTypeFactory;
use App\Factory\RegionFactory;
use App\Factory\UserFactory;
use App\Tests\TestUtil;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DynamicPropertyValueTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected string $OFFER_URI = "/api/offers";

    public function testDynamicPropertyValueValid(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dPropText"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
                "nbBeds" => 2,
                "unitPrice" => 89,
                "address" => [
                    "city" =>  $cityIRI,
                    "line1" => "Rue du matin",
                    "postalCode" => "91137"
                ],
                "offerType" => $offerTypeIRI,
                "owner" => $ownerIRI,
                "dynamicPropertyValues" => [
                    [
                        "dynamicProperty" => $dynamicPropertyIRI,
                        "value" => "2"
                    ]
                ],
                "status" => "unpublished"
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }

    /*
    * DynamicPropertyValue BINARY
    */
    public function testInvalidDynamicPropertyValueForBinaryType(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dPropBinary"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
                "nbBeds" => 2,
                "unitPrice" => 89,
                "address" => [
                    "city" =>  $cityIRI,
                    "line1" => "Rue du matin",
                    "postalCode" => "91137"
                ],
                "offerType" => $offerTypeIRI,
                "owner" => $ownerIRI,
                "dynamicPropertyValues" => [
                    [
                        "dynamicProperty" => $dynamicPropertyIRI,
                        "value" => "2"
                    ]
                ],
                "status" => "unpublished"
            ],
        ]);

        $this->assertJsonContains(["hydra:description" => "dynamicPropertyValues[0].value: Le type de la propriété dynamique \"dPropBinary\" doit être BINARY."]);
    }

    /*
    * DynamicPropertyValue NUMERICAL
    */
    public function testInvalidDynamicPropertyValueForNumericalType(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dPropNumerical"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
                "nbBeds" => 2,
                "unitPrice" => 89,
                "address" => [
                    "city" =>  $cityIRI,
                    "line1" => "Rue du matin",
                    "postalCode" => "91137"
                ],
                "offerType" => $offerTypeIRI,
                "owner" => $ownerIRI,
                "dynamicPropertyValues" => [
                    [
                        "dynamicProperty" => $dynamicPropertyIRI,
                        "value" => "text"
                    ]
                ],
                "status" => "unpublished"
            ],
        ]);

        $this->assertJsonContains(["hydra:description" => "dynamicPropertyValues[0].value: Le type de la propriété dynamique \"dPropNumerical\" doit être NUMERICAL."]);
    }

    /*
    * DynamicPropertyValue
    */
    public function testInvalidMandatoryDynamicPropertyValueEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();
        // create dynamicProperty with TEXT type
        DynamicPropertyFactory::createOne(["name" => "dPropTextMandatory", "isMandatory" => true, "type" => DynamicPropertyType::TEXT(), "offerType" => OfferTypeFactory::random()]);

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dPropTextMandatory"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
                "nbBeds" => 2,
                "unitPrice" => 89,
                "address" => [
                    "city" =>  $cityIRI,
                    "line1" => "Rue du matin",
                    "postalCode" => "91137"
                ],
                "offerType" => $offerTypeIRI,
                "owner" => $ownerIRI,
                "dynamicPropertyValues" => [
                    [
                        "dynamicProperty" => $dynamicPropertyIRI,
                        "value" => "   "
                    ]
                ],
                "status" => "unpublished"
            ],
        ]);

        $this->assertJsonContains(["hydra:description" => "dynamicPropertyValues[0].value: La valeur de la propriété dynamique \"dPropTextMandatory\" est obligatoire."]);
    }

    private function createData()
    {
        // create owner
        UserFactory::createOne([
            "email" => "test.user1@example.com",
            "roles" => [
                "ROLE_OWNER"
            ]
        ]);

        // create offerType
        OfferTypeFactory::createOne(["name" => "Cabanes"]);
        // create dynamicProperty with TEXT type
        DynamicPropertyFactory::createOne(["name" => "dPropText", "isMandatory" => false, "type" => DynamicPropertyType::TEXT(), "offerType" => OfferTypeFactory::random()]);
        // create dynamicProperty with NUMERICAL type
        DynamicPropertyFactory::createOne(["name" => "dPropNumerical", "isMandatory" => false, "type" => DynamicPropertyType::NUMERICAL(), "offerType" => OfferTypeFactory::random()]);
        // create dynamicProperty with BINARY type
        DynamicPropertyFactory::createOne(["name" => "dPropBinary", "isMandatory" => false, "type" => DynamicPropertyType::BINARY(), "offerType" => OfferTypeFactory::random()]);
        // create One country, region, city for tests
        CountryFactory::createOne(['name' => 'France']);
        RegionFactory::createOne(['name' => 'Oise', 'country' => CountryFactory::random()]);
        CityFactory::createOne(['name' => 'La Neuville-en-Hez', 'region' => RegionFactory::random()]);
    }

    // method should run before each test
    protected function setUp(): void
    {
        parent::setUp();
        ApiClientFactory::createOne(["appId" => "nextjs", "appSecret" => "jRGxlaNOSyZpvK5fExpErAhXrQR/2jYp0gaznR/v2+I="]);
    }
}
