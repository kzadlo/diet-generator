<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\DietOption;

interface DietOptionRepositoryInterface
{
    public function save(DietOption $dietOption): void;

    public function remove(DietOption $dietOption): void;
}
