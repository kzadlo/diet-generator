<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\MealType;
use App\Diet\Domain\Repository\MealTypeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class MealTypeRepository implements MealTypeRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(MealType $mealType): void
    {
        $this->entityManager->persist($mealType);
        $this->entityManager->flush();
    }

    public function remove(MealType $mealType): void
    {
        $this->entityManager->remove($mealType);
        $this->entityManager->flush();
    }
}
