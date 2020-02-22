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

    public function countAllInCalorieRange(Calorie $calorie, array $excludedIds): int
    {
        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(m.id)')
            ->from(Meal::class, 'm');

        if (!empty($excludedIds)) {
            $query
                ->andWhere('m.id NOT IN (:excludedIds)')
                ->setParameter('excludedIds', $excludedIds);
        }

        return (int) $query
            ->andWhere('m.caloriesQuantity >= :min')
            ->andWhere('m.caloriesQuantity <= :max')
            ->setParameter('min', $calorie->getMin())
            ->setParameter('max', $calorie->getMax())
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findRandomInCalorieRange(Calorie $calorie, array $excludedIds): ?Meal
    {
        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('m')
            ->from(Meal::class, 'm');

        if (!empty($excludedIds)) {
            $query
                ->andWhere('m.id NOT IN (:excludedIds)')
                ->setParameter('excludedIds', $excludedIds);
        }

        return $query
            ->andWhere('m.caloriesQuantity >= :min')
            ->andWhere('m.caloriesQuantity <= :max')
            ->setParameter('min', $calorie->getMin())
            ->setParameter('max', $calorie->getMax())
            ->setMaxResults(1)
            ->setFirstResult(rand(0, $this->countAllInCalorieRange($calorie, $excludedIds) - 1))
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllInCalorieRangeWithMeat(Calorie $calorie): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('m')
            ->from(Meal::class, 'm')
            ->join('m.ingredients', 'i')
            ->join('i.product', 'p')
            ->join('p.productType', 'pt')
            ->andWhere('pt.name = (:meatName)')
            ->andWhere('m.caloriesQuantity >= :min')
            ->andWhere('m.caloriesQuantity <= :max')
            ->setParameter('meatName', 'Mięso')
            ->setParameter('min', $calorie->getMin())
            ->setParameter('max', $calorie->getMax())
            ->getQuery()
            ->getResult();
    }
}
