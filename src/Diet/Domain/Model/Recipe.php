<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Recipe
{
    private $id;

    private $steps;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->steps = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function getOrderedSteps(): array
    {
        $array = $this->steps->toArray();
        usort($array, function ($a, $b) {
            return $a->order() > $b->order();
        });

        return $array;
    }

    public function getRecipeText(): string
    {
        $recipeText = '';

        /** @var RecipeStep $step */
        foreach ($this->getOrderedSteps() as $step) {
            $recipeText .= PHP_EOL . $step->order() . '. ' . $step->getDescription();
        }

        return trim($recipeText);
    }

    public function addStep(RecipeStep $recipeStep): Recipe
    {
        /** @var RecipeStep $step */
        foreach ($this->steps as $step) {
            if ($step->order() === $recipeStep->order()) {
                return $this;
            }
        }
        $this->steps->add($recipeStep);
        $recipeStep->setRecipe($this);
        return $this;
    }

    public function countSteps(): int
    {
        return $this->steps->count();
    }

    public function clearSteps(): Recipe
    {
        $this->steps->clear();
        return $this;
    }
}
