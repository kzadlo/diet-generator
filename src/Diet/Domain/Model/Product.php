<?php

declare(strict_types=1);

namespace App\Diet\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Product
{
    private $id;

    private $name;

    private $productType;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getProductType(): ?ProductType
    {
        return $this->productType;
    }

    public function setProductType(ProductType $productType): Product
    {
        $this->productType = $productType;
        return $this;
    }
}
