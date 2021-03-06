<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\DietOption;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class DietOptionTest extends TestCase
{
    private $dietOption;

    protected function setUp(): void
    {
        $this->dietOption = new DietOption();
    }

    public function testIsEntityValidAfterCreation(): void
    {
        $this->assertInstanceOf(UuidInterface::class, $this->dietOption->getId());
        $this->assertSame(DietOption::STANDARD_QUANTITY_DAYS, $this->dietOption->getDaysQuantity());
        $this->assertFalse($this->dietOption->hasMeatFriday());
        $this->assertSame(0, $this->dietOption->getRepetitiveDaysQuantity());
    }

    public function testCanChangeQuantityDays(): void
    {
        $this->dietOption->changeDaysQuantity(5);

        $this->assertSame(5, $this->dietOption->getDaysQuantity());
    }

    public function testCanActivateMeatFriday(): void
    {
        $this->dietOption->activateMeatFriday();

        $this->assertTrue($this->dietOption->hasMeatFriday());
    }

    public function testCanDeactivateMeatFriday(): void
    {
        $this->dietOption->deactivateMeatFriday();

        $this->assertFalse($this->dietOption->hasMeatFriday());
    }

    public function testCanChangeRepetitiveDays(): void
    {
        $this->dietOption->changeRepetitiveDaysQuantity(1);

        $this->assertSame(1, $this->dietOption->getRepetitiveDaysQuantity());
    }

    public function testCannotBeMoreRepetitiveDaysThanDays(): void
    {
        $this->dietOption->changeDaysQuantity(5);
        $this->dietOption->changeRepetitiveDaysQuantity(3);

        $this->assertSame(2, $this->dietOption->getRepetitiveDaysQuantity());
    }
}
