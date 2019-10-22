<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\DietPlanRepositoryInterface;
use Doctrine\ORM\EntityManager;

final class DietPlanRepository implements DietPlanRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
