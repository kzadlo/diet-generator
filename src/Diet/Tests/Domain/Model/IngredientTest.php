<?php

declare(strict_types=1);

namespace App\Diet\Tests\Domain\Model;

use App\Diet\Domain\Model\Ingredient;
use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\Model\Product;
use App\Diet\Domain\ValueObject\Calorie;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

final class IngredientTest extends TestCase
{
    private $ingredient;

    protected function setUp(): void
    {
        $this->ingredient = new Ingredient(
            new Product('Product Name'),
            100
        );
    }

    public function testIsEntityValidAfterCreation(): void
    {
        $this->assertInstanceOf(UuidInterface::class, $this->ingredient->getId());
        $this->assertInstanceOf(Product::class, $this->ingredient->getProduct());
        $this->assertSame(100, $this->ingredient->getWeight());
    }

    public function testCanChangeWeight(): void
    {
        $this->ingredient->changeWeight(200);

        $this->assertSame(200, $this->ingredient->getWeight());
    }

    public function testCanGetWeightWithUnit(): void
    {
        $this->assertEquals('100 g', $this->ingredient->getWeightWithUnit());
    }

    public function testCanSetMeal(): void
    {
        $meal = new Meal(
            'Meal Name',
            new Calorie(200)
        );
        $this->ingredient->setMeal($meal);

        $this->assertSame($meal, $this->ingredient->getMeal());
    }
}
