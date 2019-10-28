<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\DietPlan;
use App\Diet\Domain\Model\Owner;

interface DietPlanRepositoryInterface
{
    public function save(DietPlan $dietPlan): void;

    public function remove(DietPlan $dietPlan): void;

    public function findForOwner(Owner $owner): ?DietPlan;
}
