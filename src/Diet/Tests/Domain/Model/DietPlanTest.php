<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model;

use App\Diet\Domain\Model\DietOption;
use App\Diet\Domain\Model\DietType;
use App\Diet\Domain\Model\Owner;
use App\Diet\Tests\Helper\DietPlanFakeFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class DietPlanTest extends TestCase
{
    private $dietPlan;

    protected function setUp(): void
    {
        $this->dietPlan = (new DietPlanFakeFactory())->createDietPlanForTests();
    }

    public function testIsEntityValidAfterCreation(): void
    {
        $this->assertInstanceOf(UuidInterface::class, $this->dietPlan->getId());
        $this->assertInstanceOf(DietType::class, $this->dietPlan->getType());
        $this->assertInstanceOf(DietOption::class, $this->dietPlan->getOption());
        $this->assertInstanceOf(Owner::class, $this->dietPlan->getOwner());
        $this->assertCount(1, $this->dietPlan->getType()->getDietPlans());
    }

    public function testCanChangeType(): void
    {
        $type = new DietType('Diet Type Name 2');
        $this->dietPlan->changeType($type);

        $this->assertSame($type, $this->dietPlan->getType());
        $this->assertCount(1, $type->getDietPlans());
    }

    public function testCanChangeOption(): void
    {
        $option = new DietOption();
        $this->dietPlan->changeOption($option);

        $this->assertSame($option, $this->dietPlan->getOption());
    }

    public function testCanGetQuantityMeals(): void
    {
        $this->assertSame(DietType::MEALS_QUANTITY_FIVE, $this->dietPlan->getMealsQuantity());
    }

    public function testCanGetQuantityDays(): void
    {
        $this->assertSame(DietOption::STANDARD_QUANTITY_DAYS, $this->dietPlan->getDaysQuantity());
    }
}
