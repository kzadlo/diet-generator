<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Service;

use App\Diet\Domain\Factory\OwnerFactory;
use App\Diet\Domain\Model\BodyMeasurement;
use App\Diet\Domain\Model\DietType;
use App\Diet\Domain\Model\Owner;
use App\Diet\Domain\Service\CalorieCalculator;
use PHPUnit\Framework\TestCase;

final class CalorieCalculatorTest extends TestCase
{
    private $calorieCalculator;

    protected function setUp(): void
    {
        $this->calorieCalculator = new CalorieCalculator();
    }

    /** @dataProvider provideMealCaloriesDetails */
    public function testCanCalculatePermissibleMealCalories(int $expectedCalories, int $mealNumber)
    {
        $dietType = new DietType('Diet Type Name');

        $ownerFactory = new OwnerFactory();
        $owner = $ownerFactory->create(
            'test@email.pl',
            Owner::SEX_MALE,
            (new \DateTime())->modify('-20 years'),
            new BodyMeasurement(173, 70, CalorieCalculator::ACTIVITY_LACK)
        );

        $mealCalories = $this->calorieCalculator->calculatePermissibleMealCalories($owner, $dietType, $mealNumber);

        $this->assertEquals($expectedCalories, $mealCalories->getQuantity());
    }

    /** @dataProvider provideOwnerDetails */
    public function testCanCalculateTotalMetabolicRate(
        string $sex,
        string $ageModifyString,
        int $height,
        int $weight,
        float $activityRate,
        int $calories
    ) {
        $ownerFactory = new OwnerFactory();
        $owner = $ownerFactory->create(
            'test@email.pl',
            $sex,
            (new \DateTime())->modify($ageModifyString),
            new BodyMeasurement($height, $weight, $activityRate)
        );

        $totalMetabolicRateForOwner = $this->calorieCalculator->calculateTotalMetabolicRate($owner);

        $this->assertEquals($calories, $totalMetabolicRateForOwner);
    }

    public function provideMealCaloriesDetails(): array
    {
        return [
            'Calories of first meal' => [
                'expectedCalories' => 528,
                'mealNumber' => 1
            ],
            'Calories of second meal' => [
                'expectedCalories' => 317,
                'mealNumber' => 2
            ],
            'Calories of third meal' => [
                'expectedCalories' => 633,
                'mealNumber' => 3
            ],
            'Calories of fourth meal' => [
                'expectedCalories' => 211,
                'mealNumber' => 4
            ],
            'Calories of fifth meal' => [
                'expectedCalories' => 422,
                'mealNumber' => 5
            ],
        ];
    }

    public function provideOwnerDetails(): array
    {
        return [
            'Man 20 years old with lack activity' => [
                'sex' => Owner::SEX_MALE,
                'age' => '-20 years',
                'height' => 173,
                'weight' => 70,
                'activity' => CalorieCalculator::ACTIVITY_LACK,
                'calories' => 2111
            ],
            'Man 23 years old with low activity' => [
                'sex' => Owner::SEX_MALE,
                'age' => '-23 years',
                'height' => 176,
                'weight' => 81,
                'activity' => CalorieCalculator::ACTIVITY_LOW,
                'calories' => 2572
            ],
            'Man 26 years old with medium activity' => [
                'sex' => Owner::SEX_MALE,
                'age' => '-26 years',
                'height' => 191,
                'weight' => 88,
                'activity' => CalorieCalculator::ACTIVITY_MEDIUM,
                'calories' => 3187
            ],
            'Man 29 years old with high activity' => [
                'sex' => Owner::SEX_MALE,
                'age' => '-29 years',
                'height' => 168,
                'weight' => 65,
                'activity' => CalorieCalculator::ACTIVITY_HIGH,
                'calories' => 2807
            ],
            'Man 32 years old with top activity' => [
                'sex' => Owner::SEX_MALE,
                'age' => '-32 years',
                'height' => 177,
                'weight' => 70,
                'activity' => CalorieCalculator::ACTIVITY_TOP,
                'calories' => 3480
            ],
            'Woman 21 years old with lack activity' => [
                'sex' => Owner::SEX_FEMALE,
                'age' => '-21 years',
                'height' => 168,
                'weight' => 57,
                'activity' => CalorieCalculator::ACTIVITY_LACK,
                'calories' => 1695
            ],
            'Woman 24 years old with low activity' => [
                'sex' => Owner::SEX_FEMALE,
                'age' => '-24 years',
                'height' => 160,
                'weight' => 52,
                'activity' => CalorieCalculator::ACTIVITY_LOW,
                'calories' => 1804
            ],
            'Woman 26 years old with medium activity' => [
                'sex' => Owner::SEX_FEMALE,
                'age' => '-26 years',
                'height' => 156,
                'weight' => 49,
                'activity' => CalorieCalculator::ACTIVITY_MEDIUM,
                'calories' => 2001
            ],
            'Woman 29 years old with high activity' => [
                'sex' => Owner::SEX_FEMALE,
                'age' => '-29 years',
                'height' => 168,
                'weight' => 58,
                'activity' => CalorieCalculator::ACTIVITY_HIGH,
                'calories' => 2424
            ],
            'Woman 32 years old with top activity' => [
                'sex' => Owner::SEX_FEMALE,
                'age' => '-32 years',
                'height' => 177,
                'weight' => 68,
                'activity' => CalorieCalculator::ACTIVITY_TOP,
                'calories' => 3041
            ]
        ];
    }
}
