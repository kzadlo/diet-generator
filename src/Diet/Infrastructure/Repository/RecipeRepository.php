<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\RecipeRepositoryInterface;
use Doctrine\ORM\EntityManager;

final class RecipeRepository implements RecipeRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
