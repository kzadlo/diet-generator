<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\Meal;

interface MealRepositoryInterface
{
    public function save(Meal $meal): void;

    public function remove(Meal $meal): void;
}
