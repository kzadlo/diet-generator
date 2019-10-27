<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DietType
{
    private $id;

    private $name;

    private $description;

    private $dietPlans;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->dietPlans = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): DietType
    {
        $this->name = $name;
        return $this;
    }

    public function addDescription(string $description): DietType
    {
        $this->description = $description;
        return $this;
    }

    public function removeDescription(): DietType
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

    public function getDietPlans(): Collection
    {
        return $this->dietPlans;
    }

    public function addDietPlan(DietPlan $dietPlan): DietType
    {
        if (!$this->dietPlans->contains($dietPlan)) {
            $this->dietPlans->add($dietPlan);
            $dietPlan->changeType($this);
        }
        return $this;
    }

    public function countDietPlans(): int
    {
        return $this->dietPlans->count();
    }

    public function clearDietPlans(): DietType
    {
        $this->dietPlans->clear();
        return $this;
    }
}
