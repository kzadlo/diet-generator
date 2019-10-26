<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\BodyMeasurementRepositoryInterface;
use Doctrine\ORM\EntityManager;

final class BodyMeasurementRepository implements BodyMeasurementRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
