<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class MealType
{
    private $id;

    private $name;

    private $description;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): MealType
    {
        $this->name = $name;
        return $this;
    }

    public function addDescription(string $description): MealType
    {
        $this->description = $description;
        return $this;
    }

    public function removeDescription(): MealType
    {
        $this->description = null;
        return $this;
    }

    public function getDescription(): string
    {
        if (!$this->hasDescription()) {
            throw new \BadMethodCallException();
        }

        return $this->description;
    }

    public function hasDescription(): bool
    {
        return $this->description !== null;
    }
}
