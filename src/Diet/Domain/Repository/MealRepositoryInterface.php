<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\ValueObject\Calorie;

interface MealRepositoryInterface
{
    public function save(Meal $meal): void;

    public function remove(Meal $meal): void;

    public function countAllInCalorieRange(Calorie $calorie, array $excludedIds): int;

    public function findRandomInCalorieRange(Calorie $calorie, array $excludedIds): ?Meal;

    public function findAllInCalorieRangeWithoutMeat(Calorie $calorie): array;
}
