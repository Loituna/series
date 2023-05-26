<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher=$hasher;
    }





    public function load(ObjectManager $manager): void
    {

       // $this->addSerie($manager);
        $this->addUsers($manager);
    }


    public function addSerie(ObjectManager $manager){

        $generator = Factory::create('fr_FR');



      for  ($i=0;$i<50;$i++){
          $serie = new Serie();

          $serie
              ->setBackdrop("backdrop.png")
              ->setDateCreated($generator->dateTimeBetween("-20 years"))
              ->setGenres($generator->randomElement(['SF','Fantasy','Action','Aventure','Amour']))
              ->setName($generator->randomElement(['Breaking Bad','Game of Thrones','Chernobyl','Peaky Blinders','1883','Attaque des Titans','Sherlock']))
              ->setFirstAirDate($generator->dateTimeBetween("-20 years","-1 year"))
              ->setLastAirDate(new \DateTime("-2 month"))
              ->setPopularity($generator->numberBetween(0,1000))
              ->setPoster("poster.png")
              ->setStatus("canceled")
              ->setTmdbId($generator->randomNumber())
              ->setVote(5);

          $manager->persist($serie);

      }$manager->flush();
    }

    private function addUsers(ObjectManager $manager)
    {
        $generator = Factory::create('fr_FR');


        for  ($i=0;$i<15;$i++) {
            $user = new User();

            $user->setRoles(['ROLE_USER'])
                ->setEmail($generator->email)
                ->setFirstname($generator->firstName)
                ->setLastname($generator->lastName)
                ->setPassword($this->hasher->hashPassword($user, 'patate'));
            $manager->persist($user);
        }$manager->flush();
    }

}
