<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\BodyMeasurementRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class BodyMeasurementRepository implements BodyMeasurementRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
