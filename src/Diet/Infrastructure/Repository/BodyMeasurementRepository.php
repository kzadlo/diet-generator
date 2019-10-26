<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\BodyMeasurement;
use App\Diet\Domain\Repository\BodyMeasurementRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class BodyMeasurementRepository implements BodyMeasurementRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(BodyMeasurement $bodyMeasurement): void
    {
        $this->entityManager->persist($bodyMeasurement);
        $this->entityManager->flush();
    }

    public function remove(BodyMeasurement $bodyMeasurement): void
    {
        $this->entityManager->remove($bodyMeasurement);
        $this->entityManager->flush();
    }
}
