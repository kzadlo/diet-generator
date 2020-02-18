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
        $this->assertFalse($this->dietOption->hasMeatFriday());
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
}
