<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Day;
use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\Model\Period;
use App\Diet\Domain\ValueObject\Calorie;
use App\Diet\Tests\Helper\DietPlanFakeFactory;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class DayTest extends TestCase
{
    private $day;

    protected function setUp(): void
    {
        $this->day = new Day('Mon', new \DateTime());
    }

    public function testIsEntityValidAfterCreation(): void
    {
        $this->assertInstanceOf(UuidInterface::class, $this->day->getId());
        $this->assertSame('Mon', $this->day->getName());
        $this->assertInstanceOf(\DateTimeInterface::class, $this->day->getDate());
        $this->assertInstanceOf(Collection::class, $this->day->getMeals());
        $this->assertEmpty($this->day->getMeals());
    }

    public function testCanChangeName(): void
    {
        $this->day->changeName('Tue');

        $this->assertSame('Tue', $this->day->getName());
    }

    public function testCanCheckThatIsMeatFriday(): void
    {
        $this->assertFalse($this->day->isMeatFriday(false));
        $this->assertFalse($this->day->isMeatFriday(true));

        $this->day->changeName('Fri');

        $this->assertFalse($this->day->isMeatFriday(false));
        $this->assertTrue($this->day->isMeatFriday(true));
    }

    public function testCanChangeDate(): void
    {
        $date = new \DateTime();
        $this->day->changeDate($date);

        $this->assertSame($date, $this->day->getDate());
    }

    public function testCanSetPeriod(): void
    {
        $dietPlan = (new DietPlanFakeFactory())->createDietPlanForTests();
        $period = new Period($dietPlan);
        $this->day->setPeriod($period);

        $this->assertSame($period, $this->day->getPeriod());
    }

    public function testCanAddMeal(): void
    {
        $meal = new Meal(
            'Meal Name',
            new Calorie(200)
        );
        $this->day->addMeal($meal);

        $this->assertEquals(1, $this->day->countMeals());
    }

    public function testCannotAddSameMeal(): void
    {
        $meal = new Meal(
            'Meal Name',
            new Calorie(200)
        );
        $this->day->addMeal($meal);
        $this->day->addMeal($meal);

        $this->assertEquals(1, $this->day->countMeals());
    }

    public function testCanClearMeals(): void
    {
        $this->day->addMeal(
            new Meal(
                'Meal Name',
                new Calorie(200)
            )
        );
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
