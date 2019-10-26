<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\RecipeStepRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class RecipeStepRepository implements RecipeStepRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
