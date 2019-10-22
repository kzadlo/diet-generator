<?php

declare(strict_types=1);

namespace App\Diet\Infrastructure\Repository;

use App\Diet\Domain\Repository\MealTypeRepositoryInterface;
use Doctrine\ORM\EntityManager;

final class MealTypeRepository implements MealTypeRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
