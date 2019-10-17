<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model;

use App\Diet\Domain\Model\DietPlan;
use App\Diet\Domain\Model\DietType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class DietPlanTest extends TestCase
{
    private $dietPlan;

    protected function setUp()
    {
        $this->dietPlan = new DietPlan(new DietType('Diet Name'));
    }

    public function testEntityIsValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->dietPlan->getId());
        $this->assertInstanceOf(DietType::class, $this->dietPlan->getType());
        $this->assertSame(DietPlan::STANDARD_QUANTITY_DAYS, $this->dietPlan->getQuantityDays());
    }

    public function testCanChangeType()
    {
        $type = new DietType('Diet Name 2');
        $this->dietPlan->changeType($type);
        $this->assertSame($type, $this->dietPlan->getType());
    }

    public function testCanChangeQuantityDays()
    {
        $this->dietPlan->changeQuantityDays(5);
        $this->assertSame(5, $this->dietPlan->getQuantityDays());
    }
}
