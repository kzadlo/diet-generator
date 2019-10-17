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

    private $quantityDays;

    public function __construct(DietType $dietType)
    {
        $this->id = Uuid::uuid4();
        $this->dietType = $dietType;
        $this->quantityDays = self::STANDARD_QUANTITY_DAYS;
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
        return $this;
    }

    public function getQuantityDays(): int
    {
        return $this->quantityDays;
    }

    public function changeQuantityDays(int $quantityDays): DietPlan
    {
        $this->quantityDays = $quantityDays;
        return $this;
    }
}
