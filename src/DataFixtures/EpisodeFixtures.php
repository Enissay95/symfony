<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $episodeCount = 0;
        $faker = Factory::create();

        for ($i = 1; $i <= 500; $i++) {

            $episode = new Episode();
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(0, 100)));
            $episode->setTitle($faker->sentence());
            $episode->setNumber($episodeCount += 1);
            $episode->setSynopsis($faker->paragraph(3, true));
            $manager->persist($episode);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            SeasonFixtures::class,

        ];
    }
}
