<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Entity\UserController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

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

    /**
     * @return \Doctrine\DBAL\Statement Returns an array of Sortie objects
     */
    // Liste des utilisateurs inscrits avec PHP
    public function findPseudosSortie(int $id){
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT pseudo,user_controller.nom,prenom FROM user_controller 
            INNER JOIN user_controller_sortie ON user_controller.id=user_controller_sortie.user_controller_id
            INNER JOIN sortie ON user_controller_sortie.sortie_id=sortie.id
            WHERE sortie.id =:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $listeUsers = $stmt->fetchAll();
        return $listeUsers;
    }

    // Liste des utilisateurs inscrits avec DQL Symfony
    public function findTypeUser(int $id){
        $qb=$this->createQueryBuilder('s');
        $qb->addSelect('c.pseudo');
        $qb->from(UserController::class,'u');
        $qb->leftJoin(UserController::class,'c',Join::WITH, 's.id=c.id');
        $qb->where('s.id = :id');
        $qb->setParameter('id',$id);
        $qb->getQuery()->getResult();
       // var_dump($qb);
        return $qb;

       /* return $this->createQueryBuilder('s')
            ->addSelect('u.pseudo')
            ->from(UserController::class,'u')
            ->innerJoin(UserController::class,'c',Join::WITH, 's.id=c.id')
            ->where('s.id = :id')
            ->setParameter('id',$id)
            ->getQuery()->getResult();*/
    }


//->innerJoin('AppBundle:GroupUser', 'gu', Join::ON, 'g.id = gu.group_id')
//->andWhere('g.itinerary = :itineraryId')
//->setParameter('itineraryId', $itinerary->getId())

//    public function findPseudosSortie($id){
//        $conn = $this->getEntityManager()->getConnection();
//        $sql = "SELECT pseudo FROM user_controller INNER JOIN user_controller_sortie ON user_controller.id=user_controller_sortie.user_controller_id
//            INNER JOIN sortie ON user_controller_sortie.sortie_id=sortie.id
//            WHERE sortie.id = :id";
//        $stmt = $conn->prepare($sql);
//        $stmt->execute();
//        var_dump($stmt->fetchAll());
//        die;
//        }


//    public function findVille()
//    {
//        $conn = $this->getEntityManager()->getConnection();
//        $sql = "SELECT site.nom FROM site INNER JOIN user_controller ON site.id = user_controller.site_id WHERE user_controller.site_id=site.id";
//        $stmt = $conn->prepare($sql);
//        $stmt->execute();
//        var_dump($stmt->fetchAll());
//        return $stmt;
//        die;
//    }

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


    /* FILTRE de l'accueil
        public function findByParameters($id, $nom, $campus, $from, $to, $isOrganisateur, $isInscrit, $isNotInscrit, $isFinie)
    {
        $query = $this->createQueryBuilder("s")
            ->andWhere("s.nom LIKE :nom")->setParameter("nom", "%$nom%");
        if ($campus) { $query->andWhere("s.siteOrganisateur = :campus")->setParameter("campus", $campus); }
        if ($from) { $query->andWhere("s.dateHeureDebut >= :debut")->setParameter("debut", $from); }
        if ($to) { $query->andWhere("s.dateHeureDebut <= :fin")->setParameter("fin", $to); }
        if ($isOrganisateur) { $query->andWhere("s.organisateur = :organisateur")->setParameter("organisateur", $id); }
        if ($isInscrit) { $query->andWhere(":isInscrit MEMBER OF s.participants")->setParameter("isInscrit", $id); }
        if ($isNotInscrit) { $query->andWhere(":isNotInscrit NOT MEMBER OF s.participants")->setParameter("isNotInscrit", $id);; }
        if ($isFinie) { $query->andWhere("s.etat = :etat")->setParameter("etat", 5); }

        return $query->getQuery()->getResult();
    }


    SELECT *
    FROM sortie
    INNER JOIN
        user_controller ON sortie.organisateur_id=user_controller.id
        etat ON sortie.etats_no_etat_id=etat.id
    WHERE
     //si l'etat
        etat = "passée"
     //si on est l'organisateur
        sortie.organisateur_id = user_controller:id



     */
}
