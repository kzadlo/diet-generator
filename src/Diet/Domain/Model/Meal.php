<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use App\Diet\Domain\ValueObject\Calorie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Meal
{
    private $id;

    private $name;

    private $mealType;

    private $ingredients;

    private $recipe;

    private $caloriesQuantity;

    private $day;

    public function __construct(string $name, Calorie $calorie)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->ingredients = new ArrayCollection();
        $this->caloriesQuantity = $calorie->getQuantity();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): Meal
    {
        $this->name = $name;
        return $this;
    }

    public function getMealType(): ?MealType
    {
        return $this->mealType;
    }

    public function setMealType(?MealType $mealType): Meal
    {
        $this->mealType = $mealType;
        return $this;
    }

    public function getCalorie(): Calorie
    {
        return new Calorie($this->caloriesQuantity);
    }

    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): Meal
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setMeal($this);
        }
        return $this;
    }

    public function countIngredients(): int
    {
        return $this->ingredients->count();
    }

    public function clearIngredients(): Meal
    {
        $this->ingredients->clear();
        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function addRecipe(Recipe $recipe): Meal
    {
        $this->recipe = $recipe;
        return $this;
    }

    public function deleteRecipe(): Meal
    {
        $this->recipe = null;
        return $this;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setDay(?Day $day): Meal
    {
        $this->day = $day;
        return $this;
    }
}
