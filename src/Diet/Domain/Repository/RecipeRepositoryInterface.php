<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\Recipe;

interface RecipeRepositoryInterface
{
    public function save(Recipe $recipe): void;

    public function remove(Recipe $recipe): void;
}
