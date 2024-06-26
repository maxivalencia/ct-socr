<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        // $product = new Product();
        // $manager->persist($product);
        $user->setUsername("superadmin@cr.mg");
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'sitadmin_20#'
        ));
        $user->setRoles(['ROLE_SUPERADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}
