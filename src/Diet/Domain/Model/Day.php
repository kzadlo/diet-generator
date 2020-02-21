<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Day
{
    private $id;

    private $name;

    private $date;

    private $period;

    private $meals;

    public function __construct(string $name, \DateTimeInterface $date)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->date = $date;
        $this->meals = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): Day
    {
        $this->name = $name;
        return $this;
    }

    public function isMeatFriday(bool $hasMeatFriday): bool
    {
        return ($this->name === 'Fri' && $hasMeatFriday);
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function changeDate(\DateTimeInterface $date): Day
    {
        $this->date = $date;
        return $this;
    }

    public function getPeriod(): ?Period
    {
        return $this->period;
    }

    public function setPeriod(?Period $period): Day
    {
        $this->period = $period;
        return $this;
    }

    public function getMeals(): Collection
    {
        return $this->meals;
    }

    public function addMeal(Meal $meal): Day
    {
        if (!$this->meals->contains($meal)) {
            $this->meals->add($meal);
        }
        return $this;
    }

    public function countMeals(): int
    {
        return $this->meals->count();
    }

    public function clearMeals(): Day
    {
        $this->meals->clear();
        return $this;
    }
}
