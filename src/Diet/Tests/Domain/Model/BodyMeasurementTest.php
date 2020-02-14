<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\BodyMeasurement;
use App\Diet\Domain\Service\CalorieCalculator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class BodyMeasurementTest extends TestCase
{
    private $bodyMeasurement;

    protected function setUp(): void
    {
        $this->bodyMeasurement = new BodyMeasurement(
            180,
            90.5,
            CalorieCalculator::ACTIVITY_MEDIUM
        );
    }

    public function testIsEntityValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->bodyMeasurement->getId());
        $this->assertSame(180, $this->bodyMeasurement->getHeight());
        $this->assertSame(90.50, $this->bodyMeasurement->getKiloWeight());
        $this->assertSame(CalorieCalculator::ACTIVITY_MEDIUM, $this->bodyMeasurement->getActivityRate());
    }

    public function testCanChangeHeight()
    {
        $this->bodyMeasurement->changeHeight(200);

        $this->assertSame(200, $this->bodyMeasurement->getHeight());
    }

    public function testCanChangeWeight()
    {
        $this->bodyMeasurement->changeWeight(100);

        $this->assertSame(100.00, $this->bodyMeasurement->getKiloWeight());
    }

    public function testCanChangeActivityRate()
    {
        $this->bodyMeasurement->changeActivityRate(CalorieCalculator::ACTIVITY_TOP);

        $this->assertSame(CalorieCalculator::ACTIVITY_TOP, $this->bodyMeasurement->getActivityRate());
    }
}
