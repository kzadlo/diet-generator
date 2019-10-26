<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\Recipe;
use App\Diet\Domain\Repository\RecipeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class RecipeRepository implements RecipeRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Recipe $recipe): void
    {
        $this->entityManager->persist($recipe);
        $this->entityManager->flush();
    }

    public function remove(Recipe $recipe): void
    {
        $this->entityManager->remove($recipe);
        $this->entityManager->flush();
    }
}
