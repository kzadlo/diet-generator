<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DietOption
{
    public const STANDARD_QUANTITY_DAYS = 7;

    public const NOT_EAT_MEAT_FRIDAY = 0;

    public const EAT_MEAT_FRIDAY = 1;

    private $id;

    private $daysQuantity;

    private $hasMeatFriday;

    private $repetitiveDaysQuantity;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->daysQuantity = self::STANDARD_QUANTITY_DAYS;
        $this->hasMeatFriday = self::NOT_EAT_MEAT_FRIDAY;
        $this->repetitiveDaysQuantity = 0;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getDaysQuantity(): int
    {
        return $this->daysQuantity;
    }

    public function changeDaysQuantity(int $daysQuantity): DietOption
    {
        $this->daysQuantity = $daysQuantity;
        return $this;
    }

    public function hasMeatFriday(): bool
    {
        return (bool) $this->hasMeatFriday;
    }

    public function activateMeatFriday(): DietOption
    {
        $this->hasMeatFriday = self::EAT_MEAT_FRIDAY;
        return $this;
    }

    public function deactivateMeatFriday(): DietOption
    {
        $this->hasMeatFriday = self::NOT_EAT_MEAT_FRIDAY;
        return $this;
    }

    public function changeRepetitiveDaysQuantity(int $repetitiveDaysQuantity): DietOption
    {
        if ($repetitiveDaysQuantity > ($this->daysQuantity / 2)) {
            $repetitiveDaysQuantity = (int) ($this->daysQuantity / 2);
        }

        $this->repetitiveDaysQuantity = $repetitiveDaysQuantity;
        return $this;
    }

    public function getRepetitiveDaysQuantity(): int
    {
        return $this->repetitiveDaysQuantity;
    }
}
