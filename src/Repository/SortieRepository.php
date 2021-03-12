<?php

namespace App\Repository;

use App\Entity\Sortie;
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
    /*
    public function findPseudosSortie($id){
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT pseudo FROM user_controller INNER JOIN user_controller_sortie ON user_controller.id=user_controller_sortie.user_controller_id
            INNER JOIN sortie ON user_controller_sortie.sortie_id=sortie.id
            WHERE sortie.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        var_dump($stmt->fetchAll());die;
*/
        /* $listeUsers = $stmt->fetchAll();
         * return $listeUsers;
         */
   /* } */


    /*
    public function findPseudosSortie($id)
    {
        return $this->createQueryBuilder('s')
            ->select('s.pseudo')
        // ->andWhere('s.id =:id')
            ->innerJoin('s.user_sortie', 'sortie')
        // ->orderBy('p.status', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }*/


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
