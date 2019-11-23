<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Day;
use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\Model\Period;
use App\Diet\Domain\ValueObject\Calorie;
use App\Diet\Tests\Helper\DietPlanFactory;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class DayTest extends TestCase
{
    private $day;

    protected function setUp()
    {
        $this->day = new Day('Monday', new \DateTime());
    }

    public function testIsEntityValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->day->getId());
        $this->assertSame('Monday', $this->day->getName());
        $this->assertInstanceOf(\DateTimeInterface::class, $this->day->getDate());
        $this->assertInstanceOf(Collection::class, $this->day->getMeals());
        $this->assertEmpty($this->day->getMeals());
    }

    public function testCanChangeName()
    {
        $this->day->changeName('Tuesday');

        $this->assertSame('Tuesday', $this->day->getName());
    }

    public function testCanChangeDate()
    {
        $date = new \DateTime();
        $this->day->changeDate($date);

        $this->assertSame($date, $this->day->getDate());
    }

    public function testCanSetPeriod()
    {
        $dietPlan = (new DietPlanFactory())->createDietPlanForTests();
        $period = new Period($dietPlan);
        $this->day->setPeriod($period);

        $this->assertSame($period, $this->day->getPeriod());
    }

    public function testCanAddMeal()
    {
        $meal = new Meal(
            'Meal Name',
            new Calorie(200)
        );
        $this->day->addMeal($meal);

        $this->assertEquals(1, $this->day->countMeals());
    }

    public function testCannotAddSameMeal()
    {
        $meal = new Meal(
            'Meal Name',
            new Calorie(200)
        );
        $this->day->addMeal($meal);
        $this->day->addMeal($meal);

        $this->assertEquals(1, $this->day->countMeals());
    }

    public function testCanClearMeals()
    {
        $this->day->addMeal(
            new Meal(
                'Meal Name',
                new Calorie(200)
            ))
        ;
        $this->day->addMeal(
            new Meal(
                'Meal Name 2',
                new Calorie(300)
            )
        );

        $this->assertEquals(2, $this->day->countMeals());

        $this->day->clearMeals();

        $this->assertEmpty($this->day->getMeals());
    }
}
