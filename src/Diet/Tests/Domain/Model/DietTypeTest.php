<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model;

use App\Diet\Domain\Model\DietType;
use App\Diet\Tests\Helper\DietPlanFactory;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class DietTypeTest extends TestCase
{
    private $dietType;

    protected function setUp()
    {
        $this->dietType = new DietType('Diet Type Name');
    }

    public function testIsEntityValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->dietType->getId());
        $this->assertSame('Diet Type Name', $this->dietType->getName());
        $this->assertInstanceOf(Collection::class, $this->dietType->getDietPlans());
        $this->assertEmpty($this->dietType->getDietPlans());
        $this->assertSame(DietType::MEALS_QUANTITY_FIVE, $this->dietType->getMealsQuantity());
    }

    public function testCanChangeName()
    {
        $this->dietType->changeName('Diet Type Name 2');

        $this->assertSame('Diet Type Name 2', $this->dietType->getName());
    }

    public function testCanAddDescription()
    {
        $this->dietType->addDescription('Description for Diet Type');

        $this->assertSame('Description for Diet Type', $this->dietType->getDescription());
    }

    public function testCanRemoveDescription()
    {
        $this->dietType->addDescription('Description for Diet Type');

        $this->assertTrue($this->dietType->hasDescription());

        $this->dietType->removeDescription();

        $this->expectException(\BadMethodCallException::class);

        $this->dietType->getDescription();
    }

    public function testCanAddDietPlan()
    {
        $dietPlan = (new DietPlanFactory())->createDietPlanForTests();
        $this->dietType->addDietPlan($dietPlan);

        $this->assertEquals(1, $this->dietType->countDietPlans());
        $this->assertSame($dietPlan->getType(), $this->dietType);
    }

    public function testCannotAddSameDietPlan()
    {
        $dietPlan = (new DietPlanFactory())->createDietPlanForTests();
        $this->dietType->addDietPlan($dietPlan);
        $this->dietType->addDietPlan($dietPlan);

        $this->assertEquals(1, $this->dietType->countDietPlans());
    }

    public function testCanClearDietPlans()
    {
        $dietPlan1 = (new DietPlanFactory())->createDietPlanForTests();
        $this->dietType->addDietPlan($dietPlan1);

        $dietPlan2 = (new DietPlanFactory())->createDietPlanForTests();
        $this->dietType->addDietPlan($dietPlan2);

        $this->assertEquals(2, $this->dietType->countDietPlans());

        $this->dietType->clearDietPlans();

        $this->assertEmpty($this->dietType->getDietPlans());
    }

    public function testCanChangeMealsQuantity()
    {
        $this->dietType->applyFourMealsPerDay();

        $this->assertSame(DietType::MEALS_QUANTITY_FOUR, $this->dietType->getMealsQuantity());
    }

    public function testCanGetCaloriePerDayRates()
    {
        $this->assertCount(DietType::MEALS_QUANTITY_FIVE, $this->dietType->getCaloriePerDayRates());

        $this->dietType->applyFourMealsPerDay();

        $this->assertCount(DietType::MEALS_QUANTITY_FOUR, $this->dietType->getCaloriePerDayRates());
    }
}
