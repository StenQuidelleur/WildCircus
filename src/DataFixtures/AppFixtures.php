<?php

namespace App\DataFixtures;

use App\Entity\AgeRange;
use App\Entity\Artist;
use App\Entity\Banner;
use App\Entity\CategoryPerf;
use App\Entity\Date;
use App\Entity\Performance;
use App\Entity\PerformanceDate;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $ageRange = ['Adluts' => 100,
                    'Children (under 12 years)' => 50,
                    'Group (more than 10 persons)' => 80,
                    'School' => 50
        ];
        foreach ($ageRange as $item => $percent) {
            $ageR = new AgeRange();
            $ageR->setSpectator($item);
            $ageR->setPrice($percent);
            $manager->persist($ageR);
        }
        /*
        $categPerfArray = [];
        $categPerf = ['Clown','Magician','Acrobat'];
        foreach ($categPerf as $item) {
            $categ = new CategoryPerf();
            $categ->setName($item);
            $categ->setImage($faker->imageUrl());
            $manager->persist($categ);
            $categPerfArray[] = $categ;
        }

        $artistArray = [];
        for ($i=0; $i<6; $i++) {
            $artist = new Artist();
            $artist->setFirstname($faker->firstName);
            $artist->setLastname($faker->lastName);
            $artist->setPicture($faker->imageUrl());
            $artist->setCategory($faker->randomElement($categPerfArray));
            $artist->setResume($faker->realText($maxNbChars = 100, $indexSize = 2));
            $manager->persist($artist);
            $artistArray[] = $artist;
        }

        $performanceArray = [];
        for ($i=0; $i<6; $i++) {
            $perf = new Performance();
            $perf->setName($faker->name);
            $perf->setResume($faker->realText($maxNbChars = 100, $indexSize = 2));
            $perf->setImage($faker->imageUrl());
            $perf->setCategory($faker->randomElement($categPerfArray));
            $perf->setPrice($faker->numberBetween($min = 8, $max = 15));
            $manager->persist($perf);
            $performanceArray[] = $perf;
        }

        $dateArray = [];
        for ($i=0; $i<6; $i++) {
            $date = new Date();
            $date->setDate($faker->dateTime);
            $manager->persist($date);
            $dateArray[] = $date;
        }

        for ($i=0; $i<6; $i++) {
            $perfDate = new PerformanceDate();
            $perfDate->setDate($faker->randomElement($dateArray));
            $perfDate->setPerformance($faker->randomElement($performanceArray));
            $manager->persist($perfDate);
        }

        $bannerArray = ['Text message banner !!!! Venez on est bien ici !!!','https://images.unsplash.com/photo-1553004377-62aa53df180f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2089&q=80'];
        $banner = new Banner();
        $banner->setImage($bannerArray[1]);
        $banner->setMessage($bannerArray[0]);
        $manager->persist($banner);*/

        $user = new User();
        $user->setEmail('sten@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->encoder->encodePassword($user,'azerty'));
        $manager->persist($user);

        $manager->flush();
    }
}
