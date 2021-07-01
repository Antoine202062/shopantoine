<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($nbUsers = 1; $nbUsers <= 30; $nbUsers++){
            $user = new User();
            $user->setUsername($faker->username);
            $user->setEmail($faker->email);
            if($nbUsers === 1)
                $user->setRoles(['ROLE_ADMIN']);
            else
            $user->setRoles(['ROLE_USER']);
            $user->setUsername($faker->username);
            $user->setEmail($faker->email);
            $user->setPassword($this->encoder->encodePassword($user, 'azerty'));
            $user->setIsVerified($faker->numberBetween(0, 1));
            $manager->persist($user);

            // Enregistre l'utilisateur dans une référence
            $this->addReference('user_'. $nbUsers, $user);
        }

        $manager->flush();
    }
}
