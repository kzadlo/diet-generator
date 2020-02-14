<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\RecipeStep;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class RecipeStepTest extends TestCase
{
    private $recipeStep;

    protected function setUp(): void
    {
        $this->recipeStep = new RecipeStep('Recipe description', 1);
    }

    public function testIsEntityValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->recipeStep->getId());
        $this->assertSame(1, $this->recipeStep->order());
    }

    public function testCanChangeOrder()
    {
        $this->recipeStep->changeOrder(2);

        $this->assertSame(2, $this->recipeStep->order());
    }
}
