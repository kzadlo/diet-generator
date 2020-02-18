<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\ValueObject;

use App\Diet\Domain\ValueObject\Calorie;
use PHPUnit\Framework\TestCase;

final class CalorieTest extends TestCase
{
    private $calorie;

    protected function setUp(): void
    {
        $this->calorie = new Calorie(200);
    }

    /** @dataProvider provideCaloriesRange */
    public function testIsInRange(int $range, bool $result): void
    {
        $this->assertSame($result, $this->calorie->isInRange($range));
    }

    public function provideCaloriesRange(): array
    {
        return [
            [200 - Calorie::RANGE_SIZE, true],
            [200 + Calorie::RANGE_SIZE, true],
            [199 - Calorie::RANGE_SIZE, false],
            [201 + Calorie::RANGE_SIZE, false]
        ];
    }
}
