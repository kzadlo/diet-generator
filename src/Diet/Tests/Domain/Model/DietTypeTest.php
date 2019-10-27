<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model;

use App\Diet\Domain\Model\DietPlan;
use App\Diet\Domain\Model\DietType;
use Doctrine\Common\Collections\Collection;
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
        $this->assertInstanceOf(Collection::class, $this->dietType->getDietPlans());
        $this->assertEmpty($this->dietType->getDietPlans());
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

    public function testCanAddDietPlan()
    {
        /** @var DietPlan $dietPlan */
        $dietPlan = $this->createMock(DietPlan::class);
        $dietPlan
            ->method('getType')
            ->willReturn($this->dietType);
        $this->dietType->addDietPlan($dietPlan);
        $this->assertEquals(1, $this->dietType->countDietPlans());
        $this->assertSame($dietPlan->getType(), $this->dietType);
    }

    public function testCannotAddSameDietPlan()
    {
        /** @var DietPlan $dietPlan */
        $dietPlan = $this->createMock(DietPlan::class);
        $this->dietType->addDietPlan($dietPlan);
        $this->dietType->addDietPlan($dietPlan);
        $this->assertEquals(1, $this->dietType->countDietPlans());
    }

    public function testCanClearDietPlans()
    {
        /** @var DietPlan $dietPlan1 */
        $dietPlan1 = $this->createMock(DietPlan::class);
        $this->dietType->addDietPlan($dietPlan1);
        /** @var DietPlan $dietPlan2 */
        $dietPlan2 = $this->createMock(DietPlan::class);
        $this->dietType->addDietPlan($dietPlan2);
        $this->assertEquals(2, $this->dietType->countDietPlans());

        $this->dietType->clearDietPlans();
        $this->assertEmpty($this->dietType->getDietPlans());
    }
}
