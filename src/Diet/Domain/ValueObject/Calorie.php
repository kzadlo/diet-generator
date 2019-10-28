<?php

declare(strict_types=1);

namespace App\Diet\Domain\ValueObject;

final class Calorie
{
    public const RANGE_SIZE = 15;

    private $quantity;

    public function __construct(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getMax(): int
    {
        return $this->quantity + self::RANGE_SIZE;
    }

    public function getMin(): int
    {
        return $this->quantity - self::RANGE_SIZE;
    }

    public function isInRange(int $caloriesQuantity): bool
    {
        return $this->quantity >= ($caloriesQuantity - self::RANGE_SIZE)
            && $this->quantity <= ($caloriesQuantity + self::RANGE_SIZE);
    }
}
