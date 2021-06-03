<?php


namespace App\DataFixtures;


use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $campus = new Campus();
        $campus->setNomCampus('Nantes');
        $manager->persist($campus);
        $manager->flush();

        $campus = new Campus();
        $campus->setNomCampus('Rennes');
        $manager->persist($campus);
        $manager->flush();

        $campus = new Campus();
        $campus->setNomCampus('Niort');
        $manager->persist($campus);
        $manager->flush();
    }



}