<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class BodyMeasurement
{
    private $id;

    private $height;

    private $weight;

    private $activityRate;

    public function __construct(int $height, float $weight, float $activityRate)
    {
        $this->id = Uuid::uuid4();
        $this->height = $height;
        $this->weight = $weight * 1000;
        $this->activityRate = $activityRate;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function changeHeight(int $height): BodyMeasurement
    {
        $this->height = $height;
        return $this;
    }

    public function getKiloWeight(): float
    {
        return $this->weight / 1000;
    }

    public function changeWeight(float $weight): BodyMeasurement
    {
        $this->weight = $weight * 1000;
        return $this;
    }

    public function getActivityRate(): float
    {
        return (float) $this->activityRate;
    }

    public function changeActivityRate(float $activityRate): BodyMeasurement
    {
        $this->activityRate = $activityRate;
        return $this;
    }
}
