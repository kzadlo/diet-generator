<?php

declare(strict_types=1);

namespace App\Diet\Domain\Factory;

use App\Diet\Domain\Model\BodyMeasurement;
use App\Diet\Domain\Model\Owner;

final class OwnerFactory
{
    public function create(
        string $email,
        string $sex,
        \DateTime $birthDate,
        BodyMeasurement $bodyMeasurement
    ): Owner {
        return new Owner($email, $sex, $birthDate, $bodyMeasurement);
    }
}
