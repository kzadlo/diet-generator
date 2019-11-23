<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Ingredient;
use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\Model\MealType;
use App\Diet\Domain\Model\Product;
use App\Diet\Domain\Model\Recipe;
use App\Diet\Domain\ValueObject\Calorie;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class MealTest extends TestCase
{
    private $meal;

    protected function setUp()
    {
        $this->meal = new Meal(
            'Meal Name',
            new Calorie(200)
        );
    }

    public function testIsEntityValidAfterCreation()
    {
        $this->assertInstanceOf(UuidInterface::class, $this->meal->getId());
        $this->assertSame('Meal Name', $this->meal->getName());;
        $this->assertInstanceOf(Calorie::class, $this->meal->getCalorie());
        $this->assertInstanceOf(Collection::class, $this->meal->getIngredients());
        $this->assertEmpty($this->meal->getIngredients());
    }

    public function testCanChangeName()
    {
        $this->meal->changeName('Meal Name 2');

        $this->assertSame('Meal Name 2', $this->meal->getName());
    }

    public function testCanSetMealType()
    {
        $type = new MealType('Meal Type Name');
        $this->meal->setMealType($type);

        $this->assertSame($type, $this->meal->getMealType());
    }

    public function testCanAddIngredient()
    {
        $ingredient = new Ingredient(
            new Product('Product Name'),
            100
        );
        $this->meal->addIngredient($ingredient);

        $this->assertEquals(1, $this->meal->countIngredients());
        $this->assertSame($ingredient->getMeal(), $this->meal);
    }

    public function testCannotAddSameIngredient()
    {
        $ingredient = new Ingredient(
            new Product('Product Name'),
            100
        );
        $this->meal->addIngredient($ingredient);
        $this->meal->addIngredient($ingredient);

        $this->assertEquals(1, $this->meal->countIngredients());
    }

    public function testCanClearIngredients()
    {
        $this->meal->addIngredient(new Ingredient(
            new Product('Product Name'),
            100
            )
        );
        $this->meal->addIngredient(new Ingredient(
                new Product('Product Name'),
                100
            )
        );

        $this->assertEquals(2, $this->meal->countIngredients());

        $this->meal->clearIngredients();

        $this->assertEmpty($this->meal->getIngredients());
    }

    public function testCanDeleteRecipe()
    {
        $recipe = new Recipe();
        $this->meal->addRecipe($recipe);

        $this->assertSame($recipe, $this->meal->getRecipe());

        $this->meal->deleteRecipe();

        $this->assertNull($this->meal->getRecipe());
    }
}
