<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\ValueObject;

use App\Diet\Domain\ValueObject\Calorie;
use PHPUnit\Framework\TestCase;

class CalorieTest extends TestCase
{
    private $calorie;

    protected function setUp()
    {
        $this->calorie = new Calorie(200);
    }

    public function testHasQuantityAfterCreation()
    {
        $this->assertSame(200, $this->calorie->getQuantity());
    }

    public function testIsInRange()
    {
        $min = 200 - Calorie::RANGE_SIZE ;
        $max = 200 + Calorie::RANGE_SIZE;
        $this->assertTrue($this->calorie->isInRange($min));
        $this->assertTrue($this->calorie->isInRange($max));
        $this->assertFalse($this->calorie->isInRange(++$max));
        $this->assertFalse($this->calorie->isInRange(--$min));
    }
}
