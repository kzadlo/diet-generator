<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\BodyMeasurement;

interface BodyMeasurementRepositoryInterface
{
    public function save(BodyMeasurement $bodyMeasurement): void;

    public function remove(BodyMeasurement $bodyMeasurement): void;
}
