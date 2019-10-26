<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ProductRepository implements ProductRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
