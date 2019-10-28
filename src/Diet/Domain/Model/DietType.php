<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DietType
{
    public const MEALS_QUANTITY_FIVE = 5;

    public const MEALS_QUANTITY_FOUR = 4;

    private $fiveMealsPerDayRates = [
        1 => 0.25,
        2 => 0.15,
        3 => 0.30,
        4 => 0.10,
        5 => 0.20
    ];

    private $fourMealsPerDayRates = [
        1 => 0.25,
        2 => 0.35,
        3 => 0.20,
        4 => 0.20
    ];

    private $id;

    private $name;

    private $description;

    private $dietPlans;

    private $mealsQuantity;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->dietPlans = new ArrayCollection();
        $this->mealsQuantity = self::MEALS_QUANTITY_FIVE;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): DietType
    {
        $this->name = $name;
        return $this;
    }

    public function addDescription(string $description): DietType
    {
        $this->description = $description;
        return $this;
    }

    public function removeDescription(): DietType
    {
        $this->description = null;
        return $this;
    }

    public function getDescription(): string
    {
        if (!$this->hasDescription()) {
            throw new \BadMethodCallException();
        }

        return $this->description;
    }

    public function hasDescription(): bool
    {
        return $this->description !== null;
    }

    public function getDietPlans(): Collection
    {
        return $this->dietPlans;
    }

    public function addDietPlan(DietPlan $dietPlan): DietType
    {
        if (!$this->dietPlans->contains($dietPlan)) {
            $this->dietPlans->add($dietPlan);
            $dietPlan->changeType($this);
        }
        return $this;
    }

    public function countDietPlans(): int
    {
        return $this->dietPlans->count();
    }

    public function clearDietPlans(): DietType
    {
        $this->dietPlans->clear();
        return $this;
    }

    public function getMealsQuantity(): int
    {
        return $this->mealsQuantity;
    }

    public function applyFourMealsPerDay(): DietType
    {
        $this->mealsQuantity = self::MEALS_QUANTITY_FOUR;
        return $this;
    }

    public function getCaloriePerDayRates(): array
    {
        if ($this->mealsQuantity === self::MEALS_QUANTITY_FOUR) {
            return $this->fourMealsPerDayRates;
        }

        return $this->fiveMealsPerDayRates;
    }
}
