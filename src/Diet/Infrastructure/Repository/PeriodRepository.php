<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\Period;
use App\Diet\Domain\Repository\PeriodRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class PeriodRepository implements PeriodRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Period $period): void
    {
        $this->entityManager->persist($period);
        $this->entityManager->flush();
    }

    public function remove(Period $period): void
    {
        $this->entityManager->remove($period);
        $this->entityManager->flush();
    }
}
