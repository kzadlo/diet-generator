<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Period
{
    private $id;

    private $dietPlan;

    private $days;

    public function __construct(DietPlan $dietPlan)
    {
        $this->id = Uuid::uuid4();
        $this->dietPlan = $dietPlan;
        $this->days = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getDietPlan(): DietPlan
    {
        return $this->dietPlan;
    }

    public function changeDietPlan(DietPlan $dietPlan): Period
    {
        $this->dietPlan = $dietPlan;
        return $this;
    }

    public function getDays(): Collection
    {
        return $this->days;
    }

    public function addDay(Day $day): Period
    {
        if (!$this->days->contains($day)) {
            $this->days->add($day);
        }
        return $this;
    }

    public function countDays(): int
    {
        return $this->days->count();
    }

    public function clearDays(): Period
    {
        $this->days->clear();
        return $this;
    }
}
