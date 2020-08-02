<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\DietPlan;
use App\Diet\Domain\Model\Owner;
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

    public function findForOwner(Owner $owner): ?DietPlan
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('dp')
            ->from(DietPlan::class, 'dp')
            ->join('dp.dietType', 'dt')
            ->join('dp.dietOption', 'do')
            ->andWhere('dp.owner = :owner')
            ->setParameter('owner', $owner)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
