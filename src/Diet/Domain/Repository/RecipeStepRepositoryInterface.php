<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\RecipeStep;

interface RecipeStepRepositoryInterface
{
    public function save(RecipeStep $recipeStep): void;

    public function remove(RecipeStep $recipeStep): void;
}
