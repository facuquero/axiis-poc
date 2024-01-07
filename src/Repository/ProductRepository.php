<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Product>
 *
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

    public function upsertProductBySku(Product $product): void
    {
        $existingProduct = $this->findOneBy(['sku' => $product->getSku()]);

        if ($existingProduct !== null) {
            $existingProduct->setName($product->getName());
            $existingProduct->setSku($product->getSku());
            $existingProduct->setDescription($product->getDescription());

            $this->_em->persist($existingProduct);
        } else {
            $this->_em->persist($product);
        }

        $this->_em->flush();
    }


}
