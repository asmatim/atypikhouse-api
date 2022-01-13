<?php

namespace App\DataFixtures;

use App\Factory\AboutUsFactory;
use App\Factory\CityFactory;
use App\Factory\OfferCommentFactory;
use App\Factory\OfferFactory;
use App\Factory\OfferTypeFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadSQLDump($manager);

        AboutUsFactory::createOne();

        UserFactory::createMany(20);

        // Create unique Collections/categories
        $collections = ['Cabanes', 'Yourtes', 'Bulles', 'Tentes', 'Dôme', 'Cabanes sur Arbres'];
        foreach ($collections as $collection) {
            OfferTypeFactory::createOne(['name' => $collection]);
        }

        OfferFactory::createMany(30, function () { // note the callback - this ensures that each of the offers has a different owner
            return ['owner' => UserFactory::random(), 'city' => CityFactory::find(['name' => 'Paris'])]; // each offer set to a random Owner from those already in the database
        });

        OfferCommentFactory::createMany(70, function () {
            return ['client' => UserFactory::random(), 'offer' => OfferFactory::random()];
        });
    }

    private function loadSQLDump(ObjectManager $manager)
    {
        // Bundle to manage file and directories
        $finder = new Finder();
        $finder->in(__DIR__ . '/../../data');
        $finder->name('database.sql');
        $finder->files();

        foreach ($finder as $file) {
            print "Importing: {$file->getBasename()} " . PHP_EOL;

            $sql = $file->getContents();

            $sqls = explode("\n", $sql);

            foreach ($sqls as $sql) {
                if (trim($sql) != '') {
                    $manager->getConnection()->exec($sql);  // Execute native SQL
                }
            }

            $manager->flush();
        }
    }
}
