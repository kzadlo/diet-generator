<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\Model\MealType;
use App\Diet\Domain\ValueObject\Calorie;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class MealTypeTest extends TestCase
{
    private $mealType;

    protected function setUp(): void
    {
        $this->mealType = new MealType('Meal Type Name');
    }

    public function testIsEntityValidAfterCreation(): void
    {
        $this->assertInstanceOf(UuidInterface::class, $this->mealType->getId());
        $this->assertSame('Meal Type Name', $this->mealType->getName());
        $this->assertInstanceOf(Collection::class, $this->mealType->getMeals());
        $this->assertEmpty($this->mealType->getMeals());
    }

    public function testCanChangeName(): void
    {
        $this->mealType->changeName('Meal Type Name 2');

        $this->assertSame('Meal Type Name 2', $this->mealType->getName());
    }

    public function testCanAddDescription(): void
    {
        $this->mealType->addDescription('Description for Meal Type');

        $this->assertSame('Description for Meal Type', $this->mealType->getDescription());
    }

    public function testCanRemoveDescription(): void
    {
        $this->mealType->addDescription('Description for Meal Type');

        $this->assertTrue($this->mealType->hasDescription());

        $this->mealType->removeDescription();

        $this->expectException(\BadMethodCallException::class);

        $this->mealType->getDescription();
    }

    public function testCanAddMeal(): void
    {
        $meal = new Meal('Meal Name', new Calorie(200));
        $this->mealType->addMeal($meal);

        $this->assertEquals(1, $this->mealType->countMeals());
        $this->assertSame($meal->getMealType(), $this->mealType);
    }

    public function testCannotAddSameMeal(): void
    {
        $meal = new Meal('Meal Name', new Calorie(200));
        $this->mealType->addMeal($meal);
        $this->mealType->addMeal($meal);

        $this->assertEquals(1, $this->mealType->countMeals());
    }

    public function testCanClearMeals(): void
    {
        $this->mealType->addMeal(new Meal('Meal Name', new Calorie(200)));
        $this->mealType->addMeal(new Meal('Meal Name', new Calorie(300)));

        $this->assertEquals(2, $this->mealType->countMeals());

        $this->mealType->clearMeals();

        $this->assertEmpty($this->mealType->getMeals());
    }

    public function testCanSetOrder(): void
    {
        $this->mealType->setOrder(2);

        $this->assertSame(2, $this->mealType->order());
    }
}
