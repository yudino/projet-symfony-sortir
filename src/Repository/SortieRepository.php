<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Entity\SortieSearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findSorties(SortieSearchData $searchData, UserInterface $participant)
    {

        $qb = $this
            ->createQueryBuilder('s')
            ->innerJoin('s.etat', 'e')
            ->innerJoin('s.organisateur', 'p')
            ->innerJoin('s.campus','c')
            ->innerJoin('s.lieu', 'l')
            ->innerJoin('l.ville', 'v')
            ->leftJoin('s.inscriptions', 'i')
            ->leftJoin('i.participant', 'p2')
            ->addSelect('i')
            ->addSelect('p2')
        ;

        if(!empty($searchData->getMotCle())){
            $qb = $qb
                ->andWhere('s.nom LIKE :motCle')
                ->setParameter('motCle', "%{$searchData->getMotCle()}%")
            ;
        }

        if(!empty($searchData->getNomCampus())){
            $qb = $qb
                ->andWhere('c.id = :nomCampus')
                ->setParameter('nomCampus', $searchData->getNomCampus())
            ;
        }

        if (!empty($searchData->getDateDebutSearch() && !empty($searchData->getDateFinSearch()))){
            $qb = $qb
                ->andWhere('s.dateDebut BETWEEN :dateDebut AND :dateFin')
                ->setParameter('dateDebut', $searchData->getDateDebutSearch())
                ->setParameter('dateFin', $searchData->getDateFinSearch())
            ;
        }

        if(!empty($searchData->isSortieOrganisateur()) && $searchData->isSortieOrganisateur() === true){

            $qb = $qb
                ->andWhere('p.id =  :organisateur')
                ->setParameter('organisateur', $participant)
            ;
        }

        if(!empty($searchData->isSortieInscrit()) && $searchData->isSortieInscrit() === true){

            $qb = $qb
                ->andWhere('i.participant =  :inscrit')
                ->setParameter('inscrit', $participant)
            ;
        }

        if(!empty($searchData->isSortieNonInscrit()) && $searchData->isSortieNonInscrit() === true){

            $qb = $qb
                ->andWhere('NOT i.participant =  :nonInscrit')
                ->setParameter('nonInscrit', $participant)
            ;
        }

        if(!empty($searchData->isSortiePassees()) && $searchData->isSortiePassees() === true){
            $dateDuJour = new \DateTime();
            $qb = $qb
                ->andWhere('s.dateCloture <  :dateDujour')
                ->setParameter('dateDujour', $dateDuJour)
            ;
        }

       if(!empty($searchData->isSortiePassees()) && !empty($searchData->isSortieNonInscrit())
                 && !empty($searchData->isSortieOrganisateur()) && !empty($searchData->isSortieInscrit())){

            $qb = $this
                ->createQueryBuilder('s')
                ->innerJoin('s.etat', 'e')
                ->innerJoin('s.organisateur', 'p')
                ->innerJoin('s.campus','c')
                ->innerJoin('s.lieu', 'l')
                ->innerJoin('l.ville', 'v')
                ->leftJoin('s.inscriptions', 'i')
                ->leftJoin('i.participant', 'p2')
                ->addSelect('i')
                ->addSelect('p2')
            ;

        }


        $query = $qb->getQuery();

        return new Paginator($query) ;
    }

    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
