<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\DietTypeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DietTypeRepository implements DietTypeRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
