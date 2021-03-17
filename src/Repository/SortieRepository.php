<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Entity\UserController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     * @return Sortie[] Returns an array of Sortie objects
     */
    // Liste des utilisateurs inscrits avec PHP
    public function findPseudosSortie(int $id)
    {
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
    public function findTypeUser(int $id)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->addSelect('c.pseudo');
        $qb->from(UserController::class, 'u');
        $qb->leftJoin(UserController::class, 'c', Join::WITH, 's.id=c.id');
        $qb->where('s.id = :id');
        $qb->setParameter('id', $id);
        $qb->getQuery()->getResult();
        // var_dump($qb);
        return $qb;
    }

    // FILTRE de l'accueil
    public function findByParameters($nom)
//             public function findByParameters($id, $nom, $from, $to, $isOrganisateur, $isFinie)
    {
        $query = $this->createQueryBuilder("s")
            ->andWhere("s.nom LIKE :nom")->setParameter("SiteNom", "%$nom%");
        // if ($campus) { $query->andWhere("s.siteOrganisateur = :campus")->setParameter("site", $campus); }
        // if ($from) { $query->andWhere("s.dateHeureDebut >= :debut")->setParameter("debut", $from); }
        // if ($to) { $query->andWhere("s.dateHeureDebut <= :fin")->setParameter("fin", $to); }
        // if ($isOrganisateur) { $query->andWhere("s.organisateur = :organisateur")->setParameter("organisateur", $id); }
        //if ($isInscrit) { $query->andWhere(":isInscrit MEMBER OF s.participants")->setParameter("isInscrit", $id); }
        //if ($isNotInscrit) { $query->andWhere(":isNotInscrit NOT MEMBER OF s.participants")->setParameter("isNotInscrit", $id);; }
        // if ($isFinie) { $query->andWhere("s.etat = :etat")->setParameter("etat", 5); }
        return $query->getQuery()->getResult();
    }

    /*
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

//    public function inscription()
//    {
//        $conn = $this->getEntityManager()->getConnection();
//        $sql = "INSERT INTO user_controller_sortie(user_controller_id, sortie_id, date_inscription) VALUES ($organisateur, $sortie, $date)";
//        $stmt = $conn->prepare($sql);
//        $stmt->execute();
//        var_dump($stmt->fetchAll());
//        return $stmt;
//    }

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
    public function findInscriptions(int $Userid)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM user_controller_sortie WHERE user_controller_id = :Uid";
        //$sql = "SELECT * FROM user_controller_sortie WHERE user_controller_id = :Uid and sortie_id=:Sid";
        $stmt = $conn->prepare($sql);
       // $stmt->execute(['Uid' => $Userid,'Sid'=>$Sortieid]);
        $stmt->execute(['Uid' => $Userid]);
        $inscrit= $stmt->fetch();
        return $inscrit;

//        return $this->createQueryBuilder('u')
//            ->select('*')
//            ->from('user_controller_sortie', 'u')
//            ->andWhere('u.user_controller_id = :Uid')
//            //->andWhere('u.sortie_id = :Sid')
//            ->setParameter('Uid', $Userid)
//            //->setParameter('Sid', $Sortieid)
//            ->getQuery();
    }
}