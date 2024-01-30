<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();

        $admin->setUsername("admin");
        $admin->setEmail("adminmytwitter@gmail.com");
        $admin->setPassword($this->hasher->hashPassword($admin, "root"));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $password = $this->hasher->hashPassword($admin, "user");

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail('user_' . $i . '@gmail.com');
            $user->setUsername('user_' . $i);
            $user->setPassword($password);

            $this->addReference('user_' . $i, $user);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
