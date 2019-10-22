<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManager;

final class ProductRepository implements ProductRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
