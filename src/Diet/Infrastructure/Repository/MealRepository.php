<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\Repository\MealRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class MealRepository implements MealRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Meal $meal): void
    {
        $this->entityManager->persist($meal);
        $this->entityManager->flush();
    }

    public function remove(Meal $meal): void
    {
        $this->entityManager->remove($meal);
        $this->entityManager->flush();
    }
}
