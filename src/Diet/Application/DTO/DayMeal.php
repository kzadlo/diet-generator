<?php

declare(strict_types=1);

namespace App\Diet\Application\DTO;

class DayMeal
{
    private $mealId;

    private $dayName;

    private $date;

    private $mealName;

    private $caloriesQuantity;

    public function __construct(string $mealId, string $dayName, string $date, string $mealName, string $caloriesQuantity)
    {
        $this->mealId = $mealId;
        $this->dayName = $dayName;
        $this->date = $date;
        $this->mealName = $mealName;
        $this->caloriesQuantity = $caloriesQuantity;
    }

    public function getMealId(): string
    {
        return $this->mealId;
    }

    public function getDayName(): string
    {
        return $this->dayName;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getMealName(): string
    {
        return $this->mealName;
    }

    public function getCaloriesQuantity(): string
    {
        return $this->caloriesQuantity;
    }
}
