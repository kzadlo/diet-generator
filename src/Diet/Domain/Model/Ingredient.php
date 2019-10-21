<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Ingredient
{
    public const WEIGHT_UNIT = 'g';

    private $id;

    private $product;

    private $weight;

    private $meal;

    public function __construct(Product $product, int $weight)
    {
        $this->id = Uuid::uuid4();
        $this->product = $product;
        $this->weight = $weight;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getWeightWithUnit(): string
    {
        return $this->weight . ' ' . self::WEIGHT_UNIT;
    }

    public function changeWeight(int $weight): Ingredient
    {
        $this->weight = $weight;
        return $this;
    }

    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(?Meal $meal): Ingredient
    {
        $this->meal = $meal;
        return $this;
    }
}
