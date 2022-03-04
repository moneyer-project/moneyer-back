<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $key => $value) {
            $user = (new User())
                ->setEmail($key)
                ->setPassword($value['password'])
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
