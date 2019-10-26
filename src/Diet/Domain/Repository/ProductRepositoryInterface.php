<?php

declare(strict_types=1);

namespace App\Diet\Domain\Repository;

use App\Diet\Domain\Model\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function remove(Product $product): void;
}
