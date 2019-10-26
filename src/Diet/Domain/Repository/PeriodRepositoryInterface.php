<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\Period;

interface PeriodRepositoryInterface
{
    public function save(Period $period): void;

    public function remove(Period $period): void;
}
