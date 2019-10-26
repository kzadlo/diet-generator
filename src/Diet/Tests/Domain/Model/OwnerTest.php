<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\BodyMeasurement;
use App\Diet\Domain\Model\Owner;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class OwnerTest extends TestCase
{
    private $owner;

    protected function setUp()
    {
        $this->owner = new Owner(
            'test@email.com',
            Owner::SEX_MALE,
            new \DateTime('1995-06-19'),
            new BodyMeasurement(180, 90.5)
        );
    }

    public function testIsEntityValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->owner->getId());
        $this->assertSame('test@email.com', $this->owner->getEmail());
        $this->assertFalse($this->owner->isFemale());
        $this->assertInstanceOf(\DateTimeInterface::class, $this->owner->getBirthDate());
        $this->assertInstanceOf(BodyMeasurement::class, $this->owner->getBodyMeasurement());
    }

    public function testCanChangeEmail()
    {
        $this->owner->changeEmail('change@email.pl');
        $this->assertSame('change@email.pl', $this->owner->getEmail());
    }

    public function testCanChangeBodyMeasurement()
    {
        $bodyMeasurement = new BodyMeasurement(190, 100.5);
        $this->owner->changeBodyMeasurement($bodyMeasurement);
        $this->assertSame($bodyMeasurement, $this->owner->getBodyMeasurement());
    }

    public function testCanGetAge()
    {
        $year = $this->owner
            ->getBirthDate()
            ->diff(new \DateTime())
            ->y;

        $this->assertSame($year, $this->owner->getAge());
    }

    public function testCanSetFirstName()
    {
        $this->owner->setFirstName('First');
        $this->assertSame('First', $this->owner->getFirstName());
    }

    public function testCanSetLastName()
    {
        $this->owner->setLastName('Last');
        $this->assertSame('Last', $this->owner->getLastName());
    }
}
