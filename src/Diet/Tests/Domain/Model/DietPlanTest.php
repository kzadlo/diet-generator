<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model;

use App\Diet\Domain\Model\BodyMeasurement;
use App\Diet\Domain\Model\DietPlan;
use App\Diet\Domain\Model\DietType;
use App\Diet\Domain\Model\Owner;
use App\Diet\Domain\Service\CalorieCalculator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class DietPlanTest extends TestCase
{
    private $dietPlan;

    protected function setUp()
    {
        $this->dietPlan = new DietPlan(
            new DietType('Diet Type Name'),
            new Owner(
                'test@email.com',
                Owner::SEX_FEMALE,
                new \DateTime('1998-10-03'),
                new BodyMeasurement(
                    165,
                    20,
                    CalorieCalculator::ACTIVITY_LOW
                )
            )
        );
    }

    public function testIsEntityValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->dietPlan->getId());
        $this->assertInstanceOf(DietType::class, $this->dietPlan->getType());
        $this->assertInstanceOf(Owner::class, $this->dietPlan->getOwner());
        $this->assertCount(1, $this->dietPlan->getType()->getDietPlans());
        $this->assertSame(DietPlan::STANDARD_QUANTITY_DAYS, $this->dietPlan->getDaysQuantity());
    }

    public function testCanChangeType()
    {
        $type = new DietType('Diet Type Name 2');
        $this->dietPlan->changeType($type);
        $this->assertSame($type, $this->dietPlan->getType());
        $this->assertCount(1, $type->getDietPlans());
    }

    public function testCanChangeQuantityDays()
    {
        $this->dietPlan->changeDaysQuantity(5);
        $this->assertSame(5, $this->dietPlan->getDaysQuantity());
    }
}
