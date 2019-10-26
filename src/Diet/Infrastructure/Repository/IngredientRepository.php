<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\IngredientRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class IngredientRepository implements IngredientRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
