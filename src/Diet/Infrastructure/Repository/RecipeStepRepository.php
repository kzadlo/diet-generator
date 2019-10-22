<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\RecipeStepRepositoryInterface;
use Doctrine\ORM\EntityManager;

final class RecipeStepRepository implements RecipeStepRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
