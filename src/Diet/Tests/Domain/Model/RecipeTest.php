<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Recipe;
use App\Diet\Domain\Model\RecipeStep;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class RecipeTest extends TestCase
{
    private $recipe;

    protected function setUp()
    {
        $this->recipe = new Recipe();
    }

    public function testEntityIsValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->recipe->getId());
        $this->assertEmpty($this->recipe->getSteps());
        $this->assertInstanceOf(Collection::class, $this->recipe->getSteps());
    }

    public function testCanSetCookingTime()
    {
        $this->recipe->setCookingTime(10);
        $this->assertSame(10, $this->recipe->getCookingTime());
    }

    public function testCanGetCookingTimeWithUnit()
    {
        $this->recipe->setCookingTime(10);
        $this->assertSame('10 min', $this->recipe->getCookingTimeWithUnit());
    }

    public function testCanAddStep()
    {
        $step = new RecipeStep('Recipe description', 1);
        $this->recipe->addStep($step);
        $this->assertEquals(1, $this->recipe->countSteps());
        $this->assertSame($step->getRecipe(), $this->recipe);
    }

    public function testCannotAddStepWithSameOrder()
    {
        $this->recipe->addStep(new RecipeStep('Recipe description', 1));
        $this->recipe->addStep(new RecipeStep('Recipe description 2', 1));
        $this->assertEquals(1, $this->recipe->countSteps());
    }

    public function testCanClearSteps()
    {
        $this->recipe->addStep(new RecipeStep('Recipe description', 1));
        $this->recipe->addStep(new RecipeStep('Recipe description 2', 2));
        $this->assertEquals(2, $this->recipe->countSteps());

        $this->recipe->clearSteps();
        $this->assertEmpty($this->recipe->getSteps());
    }

    public function testCanGetOrderSteps()
    {
        $step2 = new RecipeStep('Recipe description 2', 2);
        $this->recipe->addStep($step2);
        $step1 = new RecipeStep('Recipe description 1', 1);
        $this->recipe->addStep($step1);
        $step3 = new RecipeStep('Recipe description 3', 3);
        $this->recipe->addStep($step3);
        $orderedSteps = $this->recipe->getOrderedSteps();
        $this->assertSame($orderedSteps[0], $step1);
        $this->assertSame($orderedSteps[1], $step2);
        $this->assertSame($orderedSteps[2], $step3);
    }

    public function testCanGetRecipeText()
    {
        $this->recipe->addStep(new RecipeStep('Recipe description 1', 1));
        $this->recipe->addStep(new RecipeStep('Recipe description 2', 2));
        $this->recipe->addStep(new RecipeStep('Recipe description 3', 3));

        $recipeText = '1. Recipe description 1'
            . PHP_EOL
            . '2. Recipe description 2'
            . PHP_EOL
            . '3. Recipe description 3';

        $this->assertEquals($recipeText, $this->recipe->getRecipeText());
    }
}
