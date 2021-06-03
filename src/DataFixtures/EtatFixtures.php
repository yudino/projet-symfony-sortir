<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $etat = new Etat();
        $etat->setLibelle('Créée');
        $manager->persist($etat);
        $manager->flush();

        $etat = new Etat();
        $etat->setLibelle('Ouverte');
        $manager->persist($etat);
        $manager->flush();

        $etat = new Etat();
        $etat->setLibelle('Clôturée');
        $manager->persist($etat);
        $manager->flush();

        $etat = new Etat();
        $etat->setLibelle('Activité en cours');
        $manager->persist($etat);
        $manager->flush();

        $etat = new Etat();
        $etat->setLibelle('Activité passée');
        $manager->persist($etat);
        $manager->flush();

        $etat = new Etat();
        $etat->setLibelle('Annulée');
        $manager->persist($etat);
        $manager->flush();
    }
}
