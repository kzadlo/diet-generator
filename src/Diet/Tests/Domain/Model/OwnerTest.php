<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\BodyMeasurement;
use App\Diet\Domain\Model\Owner;
use App\Diet\Domain\Service\CalorieCalculator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class OwnerTest extends TestCase
{
    private $owner;

    protected function setUp(): void
    {
        $this->owner = new Owner(
            'test@email.com',
            Owner::SEX_MALE,
            new \DateTime('1999-03-12'),
            new BodyMeasurement(180, 90.5, CalorieCalculator::ACTIVITY_LOW)
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
        $bodyMeasurement = new BodyMeasurement(190, 100.5, CalorieCalculator::ACTIVITY_HIGH);
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
        $this->owner->setFirstName('First Name');

        $this->assertSame('First Name', $this->owner->getFirstName());
    }

    public function testCanSetLastName()
    {
        $this->owner->setLastName('Last Name');

        $this->assertSame('Last Name', $this->owner->getLastName());
    }

    public function testCanGeHeight()
    {
        $this->assertSame(180, $this->owner->getHeight());
    }

    public function testCanGetWeight()
    {
        $this->assertSame(90.5, $this->owner->getWeight());
    }

    public function testCanGetActivityRate()
    {
        $this->assertSame(CalorieCalculator::ACTIVITY_LOW, $this->owner->getActivityRate());
    }
}
