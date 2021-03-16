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
     * @return \Doctrine\DBAL\Statement Returns an array of Sortie objects
     */

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
}
