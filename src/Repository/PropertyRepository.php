<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }


    /**
     * Find the all visible properties Query
     * @param PropertySearch $search
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search) : Query
    {
        // On recupere la requette initiale
        $query =  $this->findVisibleQuery();

        if ($search->getMaxPrice()){
            $query = $query
                ->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $search->getMaxPrice());
        }

        if ($search->getMinSurface()){
            $query = $query
                ->andWhere('p.surface >= :minSurface')
                ->setParameter('minSurface', $search->getMinSurface());
        }
        return $query->getQuery();
    }



    /**
     * Find the n latest and visible properties
     * Property[]
     */
    public function findLatest()
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }


    /**
     * Permit to build visible properties
     * fetch query Builder
     * @return QueryBuilder
     */
    private function findVisibleQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }
}
