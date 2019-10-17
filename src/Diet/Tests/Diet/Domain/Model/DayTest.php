<?php

declare(strict_types=1);

namespace App\Diet\Tests\Diet\Domain\Model;

use App\Diet\Domain\Model\Day;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class DayTest extends TestCase
{
    private $day;

    protected function setUp()
    {
        $this->day = new Day('Monday');
    }

    public function testEntityIsValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->day->getId());
        $this->assertSame('Monday', $this->day->getName());
    }

    public function testCanChangeName()
    {
        $this->day->changeName('Tuesday');
        $this->assertSame('Tuesday', $this->day->getName());
    }
}
