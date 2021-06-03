<?php


namespace App\DataFixtures;


use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParticipantFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $participant = new Participant();
        $participant->setPseudo('admin');
        $participant->setNom('admin');
        $participant->setPrenom('admin');
        $participant->setEmail('admin@gmel.com');
        $participant->setPassword($this->encoder->encodePassword($participant, 'admin'));
        $participant->setAdministrateur(true);
        $participant->setActif(true);
        $participant->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $manager->persist($participant);
        $manager->flush();

        $participant = new Participant();
        $participant->setPseudo('toto');
        $participant->setNom('toto');
        $participant->setPrenom('toto');
        $participant->setEmail('toto@gmel.com');
        $participant->setPassword($this->encoder->encodePassword($participant, 'toto'));
        $participant->setAdministrateur(false);
        $participant->setActif(true);
        $participant->setRoles(["ROLE_USER"]);
        $manager->persist($participant);
        $manager->flush();

        $participant = new Participant();
        $participant->setPseudo('tata');
        $participant->setNom('tata');
        $participant->setPrenom('tata');
        $participant->setEmail('tata@gmel.com');
        $participant->setPassword($this->encoder->encodePassword($participant, 'tata'));
        $participant->setAdministrateur(false);
        $participant->setActif(true);
        $participant->setRoles(["ROLE_USER"]);
        $manager->persist($participant);
        $manager->flush();

        $participant = new Participant();
        $participant->setPseudo('titi');
        $participant->setNom('titi');
        $participant->setPrenom('titi');
        $participant->setEmail('titi@gmel.com');
        $participant->setPassword($this->encoder->encodePassword($participant, 'titi'));
        $participant->setAdministrateur(false);
        $participant->setActif(true);
        $participant->setRoles(["ROLE_USER"]);
        $manager->persist($participant);
        $manager->flush();
    }



}