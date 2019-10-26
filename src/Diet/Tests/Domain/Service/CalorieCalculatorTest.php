<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Service;

use App\Diet\Domain\Model\BodyMeasurement;
use App\Diet\Domain\Model\Owner;
use App\Diet\Domain\Service\CalorieCalculator;
use PHPUnit\Framework\TestCase;

class CalorieCalculatorTest extends TestCase
{
    private $calorieCalculator;

    protected function setUp()
    {
        $this->calorieCalculator = new CalorieCalculator();
    }

    /** @dataProvider provider */
    public function testCanCalculateTotalMetabolicRate($sex, $age, $height, $weight, $activity, $calories)
    {
        $owner = new Owner(
            'test@email.pl',
            $sex,
            (new \DateTime())->modify($age),
            new BodyMeasurement($height, $weight)
        );

        $this->assertEquals($calories, $this->calorieCalculator->calculateTotalMetabolicRate($owner, $activity));
    }

    public function provider()
    {
        return [
            [
                'sex' => Owner::SEX_MALE,
                'age' => '-20 years',
                'height' => 173,
                'weight' => 70,
                'activity' => CalorieCalculator::ACTIVITY_LACK,
                'calories' => 2111
            ],
            [
                'sex' => Owner::SEX_MALE,
                'age' => '-23 years',
                'height' => 176,
                'weight' => 81,
                'activity' => CalorieCalculator::ACTIVITY_LOW,
                'calories' => 2572
            ],
            [
                'sex' => Owner::SEX_MALE,
                'age' => '-26 years',
                'height' => 191,
                'weight' => 88,
                'activity' => CalorieCalculator::ACTIVITY_MEDIUM,
                'calories' => 3187
            ],
            [
                'sex' => Owner::SEX_MALE,
                'age' => '-29 years',
                'height' => 168,
                'weight' => 65,
                'activity' => CalorieCalculator::ACTIVITY_HIGH,
                'calories' => 2807
            ],
            [
                'sex' => Owner::SEX_MALE,
                'age' => '-32 years',
                'height' => 177,
                'weight' => 70,
                'activity' => CalorieCalculator::ACTIVITY_TOP,
                'calories' => 3480
            ],
            [
                'sex' => Owner::SEX_FEMALE,
                'age' => '-21 years',
                'height' => 168,
                'weight' => 57,
                'activity' => CalorieCalculator::ACTIVITY_LACK,
                'calories' => 1695
            ],
            [
                'sex' => Owner::SEX_FEMALE,
                'age' => '-24 years',
                'height' => 160,
                'weight' => 52,
                'activity' => CalorieCalculator::ACTIVITY_LOW,
                'calories' => 1804
            ],
            [
                'sex' => Owner::SEX_FEMALE,
                'age' => '-26 years',
                'height' => 156,
                'weight' => 49,
                'activity' => CalorieCalculator::ACTIVITY_MEDIUM,
                'calories' => 2001
            ],
            [
                'sex' => Owner::SEX_FEMALE,
                'age' => '-29 years',
                'height' => 168,
                'weight' => 58,
                'activity' => CalorieCalculator::ACTIVITY_HIGH,
                'calories' => 2424
            ],
            [
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
