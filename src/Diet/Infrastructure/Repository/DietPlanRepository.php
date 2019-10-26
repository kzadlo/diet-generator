<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\DietPlan;
use App\Diet\Domain\Repository\DietPlanRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DietPlanRepository implements DietPlanRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(DietPlan $dietPlan): void
    {
        $this->entityManager->persist($dietPlan);
        $this->entityManager->flush();
    }

    public function remove(DietPlan $dietPlan): void
    {
        $this->entityManager->remove($dietPlan);
        $this->entityManager->flush();
    }
}
