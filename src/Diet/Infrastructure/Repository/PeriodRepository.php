<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\PeriodRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class PeriodRepository implements PeriodRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
