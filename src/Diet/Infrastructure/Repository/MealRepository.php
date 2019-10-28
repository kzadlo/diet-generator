<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\Repository\MealRepositoryInterface;
use App\Diet\Domain\ValueObject\Calorie;
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

    public function countAllInCalorieRange(Calorie $calorie): int
    {
        return (int) $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(m.id)')
            ->from(Meal::class, 'm')
            ->where('m.caloriesQuantity >= :min')
            ->andWhere('m.caloriesQuantity <= :max')
            ->setParameter('min', $calorie->getMin())
            ->setParameter('max', $calorie->getMax())
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findRandomInCalorieRange(Calorie $calorie): ?Meal
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('m')
            ->from(Meal::class, 'm')
            ->where('m.caloriesQuantity >= :min')
            ->andWhere('m.caloriesQuantity <= :max')
            ->setParameter('min', $calorie->getMin())
            ->setParameter('max', $calorie->getMax())
            ->setMaxResults(1)
            ->setFirstResult(rand(0, $this->countAllInCalorieRange($calorie) - 1))
            ->getQuery()
            ->getOneOrNullResult();
    }
}
