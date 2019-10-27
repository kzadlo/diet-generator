<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\ProductType;
use App\Diet\Domain\Repository\ProductTypeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductTypeRepository implements ProductTypeRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(ProductType $productType): void
    {
        $this->entityManager->persist($productType);
        $this->entityManager->flush();
    }

    public function remove(ProductType $productType): void
    {
        $this->entityManager->persist($productType);
        $this->entityManager->flush();
    }
}
