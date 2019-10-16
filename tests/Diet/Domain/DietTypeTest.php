<?php

declare(strict_types=1);

namespace App\Tests\Diet\Domain;

use App\Diet\Domain\Model\DietType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class DietTypeTest extends TestCase
{
    private $dietType;

    protected function setUp()
    {
        $this->dietType = new DietType('Diet Name');
    }

    public function testEntityIsValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->dietType->getId());
        $this->assertSame('Diet Name', $this->dietType->getName());
    }

    public function testCanChangeName()
    {
        $this->dietType->changeName('Diet Name 2');

        $this->assertSame('Diet Name 2', $this->dietType->getName());
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
