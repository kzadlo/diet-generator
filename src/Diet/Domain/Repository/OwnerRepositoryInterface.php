<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\Owner;

interface OwnerRepositoryInterface
{
    public function save(Owner $owner): void;

    public function remove(Owner $owner): void;
}
