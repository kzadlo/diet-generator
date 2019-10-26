<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\MealType;

interface MealTypeRepositoryInterface
{
    public function save(MealType $mealType): void;

    public function remove(MealType $mealType): void;
}
