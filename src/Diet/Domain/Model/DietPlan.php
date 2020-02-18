<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DietPlan
{
    public const STANDARD_QUANTITY_DAYS = 7;

    private $id;

    private $dietType;

    private $dietOption;

    private $owner;

    private $daysQuantity;

    public function __construct(DietType $dietType, DietOption $dietOption, Owner $owner)
    {
        $this->id = Uuid::uuid4();
        $this->changeType($dietType);
        $this->changeOption($dietOption);
        $this->owner = $owner;
        $this->daysQuantity = self::STANDARD_QUANTITY_DAYS;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getType(): DietType
    {
        return $this->dietType;
    }

    public function changeType(DietType $dietType): DietPlan
    {
        $this->dietType = $dietType;
        $dietType->addDietPlan($this);
        return $this;
    }

    public function getOption(): DietOption
    {
        return $this->dietOption;
    }

    public function changeOption(DietOption $dietOption): DietPlan
    {
        $this->dietOption = $dietOption;
        return $this;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function getMealsQuantity(): int
    {
        return $this->getType()->getMealsQuantity();
    }

    public function getDaysQuantity(): int
    {
        return $this->daysQuantity;
    }

    public function changeDaysQuantity(int $daysQuantity): DietPlan
    {
        $this->daysQuantity = $daysQuantity;
        return $this;
    }
}
