<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model;

use App\Diet\Domain\Model\DietType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class DietTypeTest extends TestCase
{
    private $dietType;

    protected function setUp()
    {
        $this->dietType = new DietType('Diet Type Name');
    }

    public function testIsEntityValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->dietType->getId());
        $this->assertSame('Diet Type Name', $this->dietType->getName());
    }

    public function testCanChangeName()
    {
        $this->dietType->changeName('Diet Type Name 2');
        $this->assertSame('Diet Type Name 2', $this->dietType->getName());
    }

    public function testCanAddDescription()
    {
        $this->dietType->addDescription('Description for Diet Type');
        $this->assertSame('Description for Diet Type', $this->dietType->getDescription());
    }

    public function testCanRemoveDescription()
    {
        $this->dietType->addDescription('Description for Diet Type');
        $this->assertTrue($this->dietType->hasDescription());

        $this->dietType->removeDescription();
        $this->expectException(\BadMethodCallException::class);
        $this->dietType->getDescription();
    }
}
