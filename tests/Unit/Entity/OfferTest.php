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

class OfferTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected string $OFFER_URI = "/api/offers";

    public function testCreateOfferValid(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

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

    /**
     * Title
     */
    public function testInvalildOfferTitleNotSet(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
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

        $this->assertJsonContains(["hydra:description" => "title: This value should not be null.\ntitle: This value should not be blank."]);
    }

    public function testInvalildOfferTitleEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "",
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

        $this->assertJsonContains(["hydra:description" => "title: This value is too short. It should have 10 characters or more.\ntitle: This value should not be blank."]);
    }

    public function testInvalildOfferTitleTooShort(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "aa",
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

        $this->assertJsonContains(["hydra:description" => "title: This value is too short. It should have 10 characters or more."]);
    }

    /**
     * Summary
     */
    public function testInvalildOfferSummaryNotSet(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
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

        $this->assertJsonContains(["hydra:description" => "summary: This value should not be null.\nsummary: This value should not be blank."]);
    }

    public function testInvalildOfferSummaryEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "summary" => "",
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

        $this->assertJsonContains(["hydra:description" => "summary: This value should not be blank.\nsummary: This value is too short. It should have 40 characters or more."]);
    }

    public function testInvalildOfferSummaryTooShort(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "summary" => "La Cabane des champs",
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

        $this->assertJsonContains(["hydra:description" => "summary: This value is too short. It should have 40 characters or more."]);
    }

    /**
     * Description
     */
    public function testInvalildOfferDescriptionNotSet(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
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

        $this->assertJsonContains(["hydra:description" => "description: This value should not be null.\ndescription: This value should not be blank."]);
    }

    public function testInvalildOfferDescriptionEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "description" => "",
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

        $this->assertJsonContains(["hydra:description" => "description: This value is too short. It should have 80 characters or more.\ndescription: This value should not be blank."]);
    }

    public function testInvalildOfferDescriptionTooShort(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "description" => "La Cabane des champs est idéale pour un séjour à deux.",
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

        $this->assertJsonContains(["hydra:description" => "description: This value is too short. It should have 80 characters or more."]);
    }


    /**
     * capacity
     */
    public function testInvalildOfferCapacityNegatif(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => -2,
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

        $this->assertJsonContains(["hydra:description" => "capacity: This value should be positive."]);
    }

    public function testInvalildOfferCapacityNotSet(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
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

        $this->assertJsonContains(["hydra:description" => "capacity: This value should not be null."]);
    }

    public function testInvalildOfferCapacityEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => null,
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

        $this->assertJsonContains(["hydra:description" => "capacity: This value should not be null."]);
    }

    /**
     * nbBeds
     */
    public function testInvalildOffernbBedsNegatif(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
                "nbBeds" => -2,
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

        $this->assertJsonContains(["hydra:description" => "nbBeds: This value should be positive."]);
    }

    public function testInvalildOffernbBedsNotSet(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
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

        $this->assertJsonContains(["hydra:description" => "nbBeds: This value should not be null."]);
    }

    public function testInvalildOffernbBedsEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
                "nbBeds" => null,
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

        $this->assertJsonContains(["hydra:description" => "nbBeds: This value should not be null."]);
    }

    /**
     * Price
     */
    public function testInvalildOfferPriceNegatif(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
                "nbBeds" => 2,
                "unitPrice" => -89,
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

        $this->assertJsonContains(["hydra:description" => "unitPrice: This value should be positive."]);
    }

    public function testInvalildOfferPriceNotSet(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
                "nbBeds" => 2,
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

        $this->assertJsonContains(["hydra:description" => "unitPrice: This value should not be null."]);
    }

    public function testInvalildOfferPriceEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

        // create offer
        $client->request('POST', $this->OFFER_URI, [
            'json' =>
            [
                "title" => "Cabane des Champs",
                "description" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "summary" => "La Cabane des champs est idéale pour un séjour à deux. Vous pourrez profiter du calme des lieux et de la nature, entouré des chats, poules et de la famille cochons d'inde du domaine.",
                "capacity" => 2,
                "nbBeds" => 2,
                "unitPrice" => null,
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

        $this->assertJsonContains(["hydra:description" => "The type of the \"unitPrice\" attribute must be \"int\", \"NULL\" given."]);
    }

    /**
     * offerType
     */
    public function testInvalildOfferOfferTypeNotSet(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

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

        $this->assertJsonContains(["hydra:description" => "offerType: This value should not be null."]);
    }

    public function testInvalildOfferOfferTypeEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

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
                "offerType" => null,
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

        $this->assertJsonContains(["hydra:description" => "Expected IRI or nested document for attribute \"offerType\", \"NULL\" given."]);
    }

    /**
     * owner
     */
    public function testInvalildOfferOwnerNotSet(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

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
                "dynamicPropertyValues" => [
                    [
                        "dynamicProperty" => $dynamicPropertyIRI,
                        "value" => "2"
                    ]
                ],
                "status" => "unpublished"
            ],
        ]);

        $this->assertJsonContains(["hydra:description" => "owner: This value should not be null."]);
    }

    public function testInvalildOfferOwnerEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

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
                "owner" => null,
                "dynamicPropertyValues" => [
                    [
                        "dynamicProperty" => $dynamicPropertyIRI,
                        "value" => "2"
                    ]
                ],
                "status" => "unpublished"
            ],
        ]);

        $this->assertJsonContains(["hydra:description" => "Expected IRI or nested document for attribute \"owner\", \"NULL\" given."]);
    }

    /**
     * DynamicProperties
     */
    public function testInvalildOfferDynamicPropertyValuesEmpty(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $this->createData();

        $cityIRI = $this->findIriBy(City::class, ["name" => "La Neuville-en-Hez"]);
        $offerTypeIRI = $this->findIriBy(OfferType::class, ["name" => "Cabanes"]);
        $ownerIRI = $this->findIriBy(User::class, ["email" => "test.user1@example.com"]);
        $dynamicPropertyIRI = $this->findIriBy(DynamicProperty::class, ["name" => "dp1"]);

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
                        "dynamicProperty" => null,
                        "value" => "2"
                    ]
                ],
                "status" => "unpublished"
            ],
        ]);

        $this->assertJsonContains(["hydra:description" => "Expected IRI or nested document for attribute \"dynamicProperty\", \"NULL\" given."]);
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
        // create dynamicProperty
        DynamicPropertyFactory::createOne(["name" => "dp1", "type" => DynamicPropertyType::TEXT(), "offerType" => OfferTypeFactory::random()]);
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
