<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LieuFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $lieu = new Lieu();
        $lieu->setNomLieu('Poney Club de Bel Air');
        $lieu->setRue('641 rue de Bel Air');
        $lieu->setLatitude(46.37301010744507);
        $lieu->setLongitude(-0.41177464880817466);
        //$lieu->setVille('Saint-Gelais');
        $manager->persist($lieu);
        $manager->flush();

        $lieu = new Lieu();
        $lieu->setNomLieu('Parc Chézine');
        $lieu->setRue('16 rue du Mississipi');
        $lieu->setLatitude(47.23963981831813);
        $lieu->setLongitude(-1.6090864973833077);
        //$lieu->setVille('Saint-Herblain');
        $manager->persist($lieu);
        $manager->flush();

        $lieu = new Lieu();
        $lieu->setNomLieu('Château de Goulaine');
        $lieu->setRue('Allée du Château');
        $lieu->setLatitude(47.207407465617344);
        $lieu->setLongitude(-1.403461810156539);
        //$lieu->setVille('Haute-Goulaine');
        $manager->persist($lieu);
        $manager->flush();

        $lieu = new Lieu();
        $lieu->setNomLieu('Stade de la Beaujoire');
        $lieu->setRue('Route de Saint-Joseph');
        $lieu->setLatitude(47.25723707515392);
        $lieu->setLongitude(-1.5250518845846401);
        //$lieu->setVille('Saint-Joseph de Porterie');
        $manager->persist($lieu);
        $manager->flush();

        $lieu = new Lieu();
        $lieu->setNomLieu('Forêt  - Parc Aventure');
        $lieu->setRue('Rue Maurice Audin');
        $lieu->setLatitude(48.13583150101859);
        $lieu->setLongitude(-1.6467601717105513);
        //$lieu->setVille('La Bellangerais');
        $manager->persist($lieu);
        $manager->flush();

        $lieu = new Lieu();
        $lieu->setNomLieu('La Grange des Gravelles EARL');
        $lieu->setRue('8 Bis Rue Ulger');
        $lieu->setLatitude(47.737219825512);
        $lieu->setLongitude(-1.0137297352029773);
        //$lieu->setVille('Bourg L\'Evêque');
        $manager->persist($lieu);
        $manager->flush();

        $lieu = new Lieu();
        $lieu->setNomLieu('Camping Manoir de Soeuvres');
        $lieu->setRue('Soeuvres');
        $lieu->setLatitude(48.076298244723056);
        $lieu->setLongitude(-1.5963194863062085);
        //$lieu->setVille('Chantepie');
        $manager->persist($lieu);
        $manager->flush();

        $lieu = new Lieu();
        $lieu->setNomLieu('Les Jardins  d\'Aiffres');
        $lieu->setRue('270 Rue de l\'Église');
        $lieu->setLatitude(46.285080370646654);
        $lieu->setLongitude(-0.415820718351213);
        //$lieu->setVille('Aiffres');
        $manager->persist($lieu);
        $manager->flush();

        $lieu = new Lieu();
        $lieu->setNomLieu('Maison du Marais Poitevin');
        $lieu->setRue('5 Place de la Coutume');
        $lieu->setLatitude(46.32277642900861);
        $lieu->setLongitude(-0.5872707185543189);
        //$lieu->setVille('Coulon');
        $manager->persist($lieu);
        $manager->flush();
    }
}
