<?php

namespace App\DataFixtures;

use App\Entity\Tweet;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TweetFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        for ($i = 0; $i < 300; $i++) {
            $tweet = new Tweet();
            $tweet->setMessage($faker->text());
            $tweet->setTitle($faker->words(5, true));
            $datetimeImmutable = DateTimeImmutable::createFromMutable($faker->dateTimeBetween("-2 year", 'now'));
            $tweet->setCreatedAt($datetimeImmutable);
            $tweet->setUser($this->getReference("user_" . random_int(0, 99)));
            $manager->persist($tweet);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
