<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\DietType;

interface DietTypeRepositoryInterface
{
    public function save(DietType $dietType): void;

    public function remove(DietType $dietType): void;
}
