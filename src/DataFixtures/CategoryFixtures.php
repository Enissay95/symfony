<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class CategoryFixtures extends Fixture implements FixtureGroupInterface
{

    const CATEGORIES = [
        'Action',
        'Aventure',
        'Fantastique',
        'Horreur',
    ];

    public function load(ObjectManager $manager)
    {

        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('category_' . $categoryName, $category);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }
}
