<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $admin = new User();
        $admin->setEmail('admin@adminhub.fr')
            ->setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $manager->persist($admin);

        $acc_manager = new User();
        $acc_manager->setEmail('manager@adminhub.fr')
            ->setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setRoles(['ROLE_MANAGER']);
        $acc_manager->setPassword($this->passwordHasher->hashPassword($acc_manager, 'password'));
        $manager->persist($acc_manager);

        $user = new User();
        $user->setEmail('user@adminhub.fr')
            ->setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->safeEmail())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
