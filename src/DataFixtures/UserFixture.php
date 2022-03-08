<?php

namespace App\DataFixtures;

use App\Entity\Bank\Account;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Yaml\Yaml;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $key => $value) {
            $user = new User();

            $user
                ->setEmail($key)
                ->setPassword($this->userPasswordHasher->hashPassword($user, $value['password']))
                ->setAccount((new Account())->setName($key))
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }

    protected function getData()
    {
        return Yaml::parseFile(__DIR__ . '/../../assets/fixtures/users.yaml');
    }
}
