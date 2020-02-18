<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\DietOption;
use App\Diet\Domain\Repository\DietOptionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DietOptionRepository implements DietOptionRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(DietOption $dietOption): void
    {
        $this->entityManager->persist($dietOption);
        $this->entityManager->flush();
    }

    public function remove(DietOption $dietOption): void
    {
        $this->entityManager->remove($dietOption);
        $this->entityManager->flush();
    }
}
