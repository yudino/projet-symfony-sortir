<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\AnnulationSortieType;
use App\Form\CreationSortieType;
use App\Form\ModifSortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/creationSortie", name="sortie_creation")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function creationSortie(EntityManagerInterface $em, Request $request): Response
    {
        $username = $this->getUser()->getUsername();
        $organisateur = $this->getDoctrine()->getRepository(Participant::class)
            ->findOneByPseudoOrEmail($username);

        $sortie = new Sortie();
        $sortie->setOrganisateur($organisateur);
        $sortie->setCampus($organisateur->getCampus());
        $inscription = new Inscription();
        $inscription->setDateInscription(new \DateTime());
        $inscription->setSortie($sortie);
        $inscription->setParticipant($organisateur);
        $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle'=>'Créée']);
        $sortie->setEtat($etat);
        $sortieForm = $this->createForm(CreationSortieType::class, $sortie);
        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){

            $em->persist($sortie);
            $em->persist($inscription);
            $em->flush();

            $this->addFlash('success', 'La sortie a bien été créée');
            return $this->redirectToRoute('home');
        }


        return $this->render('sortie/creation_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'sortieForm' => $sortieForm->createView(),
        ]);
    }

    /**
     * @Route("annulationSortie/{id}", name="sortie_annulation")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function annulationSortie(EntityManagerInterface $em, Request $request, $id): Response
    {
        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        if(empty($sortie)){
            throw $this->createNotFoundException('Cette sortie n\'existe pas');
        }

        $annulationForm = $this->createForm(AnnulationSortieType::class, $sortie);
        $annulationForm->handleRequest($request);
        /*$dateNow = new \DateTime();
        if($sortie->getDateCloture() > $dateNow){*/
            if($annulationForm->isSubmitted() && $annulationForm->isValid()){
                $etat = $this->getDoctrine()->getRepository(Etat::class)
                    ->findOneBy(['libelle'=>'Annulée']);
                $sortie->setEtat($etat);
                $em->persist($sortie);
                $em->flush();

                $this->addFlash('success', 'La sortie a bien été annulée');
                return $this->redirectToRoute('home');
            }
        /*} else {
            $this->createNotFoundException('Il est trop tard pour annuler cette sortie..!');
        }*/
        return $this->render('sortie/annulation_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'sortie' => $sortie,
            'annulationForm' => $annulationForm->createView(),
            ]);
    }

    /**
     * @Route("modifSortie/{id}", name="sortie_modif")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function modifSortie(EntityManagerInterface $em, Request $request, $id): Response
    {

        $sortie = $this->getDoctrine()->getRepository(Sortie::class)->find($id);
        if(empty($sortie)){
            throw $this->createNotFoundException('Cette sortie n\'existe pas');
        }
        $modifForm = $this->createForm(ModifSortieType::class, $sortie);
        $modifForm->handleRequest($request);
        if($modifForm->isSubmitted() && $modifForm->isValid()){
            $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle'=>'Créée']);
            $sortie->setEtat($etat);
            $em->persist($sortie);
            $em->flush();

            $this->addFlash('success', 'La sortie a bien été modifiée');
            return $this->redirectToRoute('home');
        }
        return $this->render('sortie/modif_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'sortie' => $sortie,
            'modifForm' => $modifForm->createView(),
        ]);
    }

    /**
     * @Route("suppressionSortie/{id}",name="sortie_suppression", methods={"DELETE"})
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function suppressionSortie(EntityManagerInterface $em, Request $request, $id):Response
    {
        $sortie=$this->getDoctrine()->getRepository(Sortie::class)->find($id);
        if(empty($sortie)){
            throw$this->createNotFoundException('Cette sortie n\'existe pas');
        }
       if($this->isCsrfTokenValid('delete'.$sortie->getId(), $request->request->get('_token'))){
           $em->remove($sortie);
           $em->flush();
       }

        $this->addFlash('success','La sortie a bien été supprimée');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("publierSortie/{id}", name="sortie_publier")
     * @param EntityManagerInterface $em
     * @param $id
     * @return Response
     */
    public function publierSortie(EntityManagerInterface $em, $id): Response
    {
        $sortie=$this->getDoctrine()->getRepository(Sortie::class)->find($id);
        if(empty($sortie)){
            throw$this->createNotFoundException('Cette sortie n\'existe pas');
        }

        $etat = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle'=>'Ouverte']);
        $sortie->setEtat($etat);
        $em->persist($sortie);
        $em->flush();

        $this->addFlash('success','La sortie a bien été publiée');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("afficherSortie/{id}", name="sortie_afficher")
     * @param $id
     * @return Response
     */
    public function afficherSortie($id): Response
    {
        $sortie=$this->getDoctrine()->getRepository(Sortie::class)->find($id);
        if(empty($sortie)){
            throw$this->createNotFoundException('Cette sortie n\'existe pas');
        }

        return $this->render('sortie/afficher_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'sortie' => $sortie,
        ]);
    }

    /**
     * @Route("listeLieuxParVille", name="sortie_liste_lieux")
     */
    public function listeLieuxParVille(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $lieuxRepo = $em->getRepository(Lieu::class);

        $villeId = $request->query->get('villeId');
        $ville = $em->getRepository(Ville::class)->find($villeId);
        $cdp = $ville->getCodePostal();

        $lieux = $lieuxRepo->findLieuByVille($villeId);

        $responseArray = array();
        foreach ($lieux as $lieu){
            $responseArray[] = array(
                "id" => $lieu->getId(),
                "name" => $lieu->getNomLieu(),
                "rue" => $lieu->getRue(),
                "latitude" => $lieu->getLatitude(),
                "longitude" => $lieu->getLongitude(),
                "cdp" => $cdp,
            );
        }
        return new JsonResponse($responseArray);
    }

    /**
     * @Route("lieuDetails", name="sortie_lieu_details")
     */
    public function lieuDetails(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $lieuRepo = $em->getRepository(Lieu::class);
        $lieuId = $request->query->get('lieuId');
        $lieu = $lieuRepo->find($lieuId);

        $retourArray = array();

        $retourArray[] = array(
            "id" => $lieu->getId(),
            "name" => $lieu->getNomLieu(),
            "rue" => $lieu->getRue(),
            "latitude" => $lieu->getLatitude(),
            "longitude" => $lieu->getLongitude(),
        );

        return new JsonResponse($retourArray);
    }



    private $date;
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @Route("inscription/{id}", name="sortie_inscription")
     * @param EntityManagerInterface $em
     * @param $id
     * @return Response
     */
    public function inscription(EntityManagerInterface $em, $id): Response
    {

        $sortieRepository = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        $nbInscription = $sortie->getInscriptions();
        $nbInscriptionMax = $sortie->getNbInscriptionsMax();
        $dateMaxInscription = $sortie->getDateCloture();

        $user = $this->getUser();

        if (count($nbInscription) < $nbInscriptionMax and $dateMaxInscription >  $this->date) {
            $inscription = new Inscription();
            $inscription->setParticipant($user);
            $inscription->setSortie($sortie);
            $inscription->setDateInscription($this->date);

            if(count($nbInscription)+1 === $nbInscriptionMax){
                $sortie->setEtatSortie('Cloturee');
                $em->persist($sortie);
            }

            $em->persist($inscription);
            $em->flush();

            $this->addFlash('message', 'Votre inscription a bien été ajoutée !');
            return $this->redirectToRoute('home');
        }


        if (count($nbInscription) === $nbInscriptionMax) {
            $this->addFlash('error', 'Le nombre maximum de participant est atteint !');
        }

        if ( $this->date > $dateMaxInscription ) {
            $this->addFlash('error', 'Vous ne pouvez pas vous inscrire à cette sortie, la date limite d\'inscription est dépassée');
        }
        return $this->redirectToRoute('home');

    }


    /**
     * @Route("desister/{id}", name="sortie_desister")
     * @param $id
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function desister(EntityManagerInterface $em, $id)
    {

        $participant = $this->getUser();

        $sortieRepository = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        $inscriptionRepository = $em->getRepository(Inscription::class);
        $inscription = $inscriptionRepository->findBy(
            ['sortie' => $sortie->getId(), 'participant' => $participant->getId()],
            ['sortie' => 'ASC']
        );

        $nombreInscriptions = $sortie->getInscriptions();
        $nombreInscriptionsMax = $sortie->getNbInscriptionsMax();
        $etat = $sortie->getEtatSortie(); //ou getEtat
        if(count($nombreInscriptions)-1 < $nombreInscriptionsMax && $etat === 'Cloture'){
            $sortie->setEtat('Ouverte');
            $em->persist($sortie);
        }

        $em->remove($inscription[0]);
        $em->flush();

        $this->addFlash('success', 'Votre annulation a bien été prise en compte !');
        return $this->redirectToRoute('home');

      }

}
