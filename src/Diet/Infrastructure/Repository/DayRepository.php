<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Model\Day;
use App\Diet\Domain\Repository\DayRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DayRepository implements DayRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Day $day): void
    {
        $this->entityManager->persist($day);
        $this->entityManager->flush();
    }

    public function remove(Day $day): void
    {
        $this->entityManager->remove($day);
        $this->entityManager->flush();
    }
}
