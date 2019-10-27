<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Day;
use App\Diet\Domain\Model\DietPlan;
use App\Diet\Domain\Model\DietType;
use App\Diet\Domain\Model\Period;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class PeriodTest extends TestCase
{
    private $period;

    protected function setUp()
    {
        /** @var DietPlan $dietPlan */
        $dietPlan = $this->createMock(DietPlan::class);
        $this->period = new Period($dietPlan);
    }

    public function testIsEntityValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->period->getId());
        $this->assertInstanceOf(DietPlan::class, $this->period->getDietPlan());
        $this->assertInstanceOf(Collection::class, $this->period->getDays());
        $this->assertEmpty($this->period->getDays());
    }

    public function testCanChangeDietPlan()
    {
        /** @var DietPlan $dietPlan */
        $dietPlan = $this->createMock(DietPlan::class);
        $this->period->changeDietPlan($dietPlan);
        $this->assertSame($dietPlan, $this->period->getDietPlan());
    }

    public function testCanAddDay()
    {
        $day = new Day('Name', new \DateTime());
        $this->period->addDay($day);
        $this->assertEquals(1, $this->period->countDays());
        $this->assertSame($day->getPeriod(), $this->period);
    }

    public function testCannotAddSameDay()
    {
        $day = new Day('Name', new \DateTime());
        $this->period->addDay($day);
        $this->period->addDay($day);
        $this->assertEquals(1, $this->period->countDays());
    }

    public function testCanClearDays()
    {
        $this->period->addDay(new Day('Name', new \DateTime()));
        $this->period->addDay(new Day('Name', new \DateTime()));
        $this->assertEquals(2, $this->period->countDays());

        $this->period->clearDays();
        $this->assertEmpty($this->period->getDays());
    }
}
