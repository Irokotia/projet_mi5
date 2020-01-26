<?php

namespace App\Repository;

use App\Entity\LigneCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LigneCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneCommande[]    findAll()
 * @method LigneCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneCommande::class);
    }

    // /**
    //  * @return LigneCommande[] Returns an array of LigneCommande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneCommande
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getSommeProduitByCommandes(){
        return $this->createQueryBuilder('l')
            ->groupBy('l.commande')
            ->orderBy('l.commande','DESC')
            ->select('l.id,(l.commande) as commande,SUM(l.prix) as prix')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getTopVentes(){
        $entityManager = $this->getEntityManager();

        $qb = $this->createQueryBuilder('o');

        $qb->select('SUM(o.quantite) AS quantite')
            ->groupBy('o.produit')
            ->orderBy('quantite', 'DESC')
            ->addSelect('(o.produit)','(o.id)')
            ->setMaxResults(4);

        /*$qb->select('SUM(o.quantite) AS quantite')
            ->groupBy('o.produit')
            ->addSelect('o.produit','o.id')
            ->orderBy('o.quantite', 'DESC');*/
        // ne marche pas récupére uniquement l'id du produit donc obliger de récupérer le produit entier avec son id

        return $qb->getQuery()->getResult();
    }
}
