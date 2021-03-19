<?php

namespace App\Repository;

use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\UserController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;


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
        $qb->innerJoin(UserController::class, 'c', Join::WITH, 's.id=c.id');
        $qb->where('s.id = :id');
        $qb->setParameter('id', $id);
        $qb->getQuery()->getResult();
        return $qb;
    }

    // Filtre de l'accueil
    public function findByParameters($site,$nom,$sortieDate1,$sortieDate2)
    {
        $query = $this -> createQueryBuilder("s");

        if ($site) {
            $query -> andWhere("s.site_organisateur = :site")->setParameter("site", $site);
        }

        if ($nom){
            $query -> andWhere("s.nom LIKE :nom")->setParameter("nom", "%$nom%");
        }

        if ($sortieDate1 && $sortieDate2) {
            $query -> andWhere("s.date_debut BETWEEN :dateD AND :dateF")->setParameter("dateD", $sortieDate2)->setParameter("dateF", $sortieDate1);
        }
        return $query->getQuery()->getResult();
    }


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