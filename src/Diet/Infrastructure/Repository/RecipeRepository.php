<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\RecipeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class RecipeRepository implements RecipeRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
