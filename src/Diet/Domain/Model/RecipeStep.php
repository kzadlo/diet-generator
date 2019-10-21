<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RecipeStep
{
    private $id;

    private $description;

    private $order;

    private $recipe;

    public function __construct(string $description, int $order)
    {
        $this->id = Uuid::uuid4();
        $this->description = $description;
        $this->order = $order;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function order(): int
    {
        return $this->order;
    }

    public function changeOrder(int $order): RecipeStep
    {
        $this->order = $order;
        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): RecipeStep
    {
        $this->recipe = $recipe;
        return $this;
    }
}
