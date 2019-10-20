<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Day;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class DayTest extends TestCase
{
    private $day;

    protected function setUp()
    {
        $this->day = new Day('Monday', new \DateTime());
    }

    public function testEntityIsValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->day->getId());
        $this->assertSame('Monday', $this->day->getName());
        $this->assertInstanceOf(\DateTimeInterface::class, $this->day->getDate());
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
}
