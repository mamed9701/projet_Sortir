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
     * @return Sortie[] Returns an array of Sortie objects
     */

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
