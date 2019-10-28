<?php

declare(strict_types=1);

namespace App\Diet\Domain\Service;

use App\Diet\Domain\Model\DietType;
use App\Diet\Domain\Model\Owner;
use App\Diet\Domain\ValueObject\Calorie;

class CalorieCalculator
{
    public const ACTIVITY_LACK = 1.2;
    public const ACTIVITY_LOW = 1.35;
    public const ACTIVITY_MEDIUM = 1.55;
    public const ACTIVITY_HIGH = 1.75;
    public const ACTIVITY_TOP = 2.05;

    public function calculatePermissibleMealCalories(Owner $owner, DietType $dietType, int $mealNumber): Calorie
    {
        $totalCaloriesPerDay = $this->calculateTotalMetabolicRate($owner);
        $mealCalories = (int) round($dietType->getCaloriePerDayRates()[$mealNumber] * $totalCaloriesPerDay->getQuantity());

        return new Calorie($mealCalories);
    }

    public function calculateTotalMetabolicRate(Owner $owner): Calorie
    {
        $bmr = $owner->isFemale()
            ? $this->femaleFormula($owner->getWeight(), $owner->getHeight(), $owner->getAge())
            : $this->maleFormula($owner->getWeight(), $owner->getHeight(), $owner->getAge());

        $totalMetabolicRate = (int) round($bmr * $owner->getActivityRate());

        return new Calorie($totalMetabolicRate);
    }

    private function femaleFormula(float $weight, int $height, int $age): float
    {
        return 655.1 + (9.563 * $weight) + (1.85 * $height) - (4.676 * $age);
    }

    private function maleFormula(float $weight, int $height, int $age): float
    {
        return 66.5 + (13.75 * $weight) + (5.003 * $height) - (6.775 * $age);
    }
}
