<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\ProductType;

interface ProductTypeRepositoryInterface
{
    public function save(ProductType $productType): void;

    public function remove(ProductType $productType): void;
}
