<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\Ingredient;

interface IngredientRepositoryInterface
{
    public function save(Ingredient $ingredient): void;

    public function remove(Ingredient $ingredient): void;
}
