<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\OwnerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class OwnerRepository implements OwnerRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
