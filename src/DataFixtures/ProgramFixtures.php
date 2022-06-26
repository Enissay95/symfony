<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class ProgramFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public const PROGRAMS = [
        [
            'title' => 'Breaking Bad',
            'synopsis' => 'United States',
            'poster' => 'https://www.pause-canap.com/media/wysiwyg/serie-breaking-bad.JPG',
            'category' => 'Action',
        ],
        [
            'title' => 'Walking dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'poster' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQBeOyGyGM3ML8aaokhGBZw9Uei1_HNFoMxIw&usqp=CAU',
            'category' => 'Horreur',
        ],
        [
            'title' => 'Game of Thrones',
            'synopsis' => 'Nine noble families fight for control over the mythical lands of Westeros, while an ancient enemy returns after being dormant for thousands of years.',
            'poster' => 'https://www.foxnews.com/opinion/racism-in-game-of-thrones-season-3-finale',
            'category' => 'Fantastique',
        ],
        [
            'title' => 'The hundred',
            'synopsis' => 'A group of survivors from the earth is forced to face a deadly virus that has been unleashed on the planet.',
            'poster' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQai44tAk1YWRMPvasGyP8GzZ5n7OHC3ivmhg&usqp=CAU',
            'category' => 'Aventure',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $key => $programData) {
            $program = new Program();
            $program->setTitle($programData['title']);
            $program->setSynopsis($programData['synopsis']);
            $program->setPoster($programData['poster']);
            $program->setCategory($this->getReference('category_' . $programData['category']));
            $this->addReference('program_' . $key, $program);
            $manager->persist($program);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}
