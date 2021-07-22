<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Size;
use App\Entity\SearchProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findBySearch(SearchProduct $searchProduct): array
    {
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :title')
            ->setParameter('title', '%' . $searchProduct->getTitle() . '%');
        if ($searchProduct->getCategory()) {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', $searchProduct->getCategory());
        }
       
        if ($searchProduct->getMinPrice()) {
            $qb->andWhere('p.prix > :minPrice')
                ->setParameter('minPrice', $searchProduct->getMinPrice());
        }
        if ($searchProduct->getMaxPrice()) {
            $qb->andWhere('p.prix < :maxPrice')
                ->setParameter('maxPrice', $searchProduct->getMaxPrice());
        }
        $qb->orderBy('p.price', $searchProduct->getSortByPrice());

        return $qb->getQuery()
            ->getResult();
    }
}
